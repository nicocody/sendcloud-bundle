<?php

namespace Sendcloud\Bundle\Service;

use Sendcloud\Bundle\DTO\Shipment;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ShipmentService
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly ValidatorInterface $validator,
        private readonly string $baseUrl,
        private readonly string $apiKey,
        private readonly string $apiSecret,
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

        $response = $this->client->request('POST', rtrim($this->baseUrl, '/').'/shipments/announce', [
            'auth_basic' => [$this->apiKey, $this->apiSecret],
            'json' => ['shipment' => $shipment->toArray()],
        ]);

        return $response->toArray();
    }
}

