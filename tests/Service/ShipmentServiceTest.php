<?php

namespace Sendcloud\Bundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Address;
use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\Exception\SendcloudApiException;
use Sendcloud\Bundle\Service\ShipmentService;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Psr\Log\LoggerInterface;

class ShipmentServiceTest extends TestCase
{
    private Shipment $shipment;

    protected function setUp(): void
    {
        $to = new Address(
            'John Doe',
            null,
            'Main Street',
            '42',
            '12345',
            'Metropolis',
            'NL',
            null,
            null,
        );
        $from = new Address(
            'Jane Sender',
            null,
            'Elm Street',
            '13',
            '54321',
            'Gotham',
            'US',
            null,
            null,
        );
        $this->shipment = new Shipment($to, $from, 1.0);
    }

    public function testAnnounceShipmentReturnsResponseArray(): void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $validator->method('validate')->with($this->shipment)->willReturn(new ConstraintViolationList());
        $client->expects(self::once())
            ->method('request')
            ->with(
                'POST',
                'https://api.example.com/shipments/announce',
                [
                    'auth_basic' => ['key', 'secret'],
                    'json' => ['shipment' => $this->shipment->toArray()],
                ]
            )->willReturn($response);
        $response->method('toArray')->willReturn(['status' => 'ok']);

        $service = new ShipmentService($client, $validator, 'https://api.example.com', 'key', 'secret');
        $result = $service->announceShipment($this->shipment);

        self::assertSame(['status' => 'ok'], $result);
    }

    public function testAnnounceShipmentThrowsOnValidationErrors(): void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $violation = $this->createMock(ConstraintViolation::class);
        $validator->method('validate')->willReturn(new ConstraintViolationList([$violation]));

        $service = new ShipmentService($client, $validator, 'https://api.example.com', 'key', 'secret');

        $this->expectException(ValidationFailedException::class);
        $service->announceShipment($this->shipment);
    }

    public function testAnnounceShipmentThrowsApiExceptionWithResponseMessage(): void
    {
        $client = $this->createMock(HttpClientInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $validator->method('validate')->willReturn(new ConstraintViolationList());
        $client->method('request')->willReturn($response);

        $exception = new class($response) extends \Exception implements HttpExceptionInterface {
            public function __construct(private ResponseInterface $response) { parent::__construct('error', 400); }
            public function getResponse(): ResponseInterface { return $this->response; }
        };

        $response->method('toArray')->willThrowException($exception);
        $response->method('getContent')->with(false)->willReturn('{"error":{"message":"Invalid address"}}');

        $logger->expects(self::once())->method('error')->with(
            'Sendcloud API error: {"error":{"message":"Invalid address"}}',
            self::arrayHasKey('exception')
        );

        $service = new ShipmentService($client, $validator, 'https://api.example.com', 'key', 'secret', $logger);

        $this->expectException(SendcloudApiException::class);
        $this->expectExceptionMessage('Invalid address');
        $service->announceShipment($this->shipment);
    }
}
