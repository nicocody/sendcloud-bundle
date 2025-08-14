<?php

namespace Sendcloud\Bundle\Service;

use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\Exception\SendcloudApiException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class ShipmentService
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly ValidatorInterface $validator,
        private readonly string $baseUrl,
        private readonly string $apiKey,
        private readonly string $apiSecret,
        private readonly ?LoggerInterface $logger = null,
    ) {
    }

    /**
     * @throws ValidationFailedException
     */
    public function announceShipment(Shipment $shipment): array
    {
        $errors = $this->validator->validate($shipment);
        if (count($errors) > 0) {
            throw new ValidationFailedException($shipment, $errors);
        }

        try {
            $response = $this->client->request('POST', rtrim($this->baseUrl, '/').'/shipments/announce', [
                'auth_basic' => [$this->apiKey, $this->apiSecret],
                'json' => ['shipment' => $shipment->toArray()],
            ]);

            return $response->toArray();
        } catch (HttpExceptionInterface $e) {
            $content = $e->getResponse()->getContent(false);

            if ($this->logger) {
                $this->logger->error('Sendcloud API error: '.$content, ['exception' => $e]);
            }

            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['error']['message'])) {
                $message = $decoded['error']['message'];
            } else {
                $message = $content;
            }

            throw new SendcloudApiException($message, $e->getCode(), $e);
        }
    }
}

