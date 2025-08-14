<?php

namespace Sendcloud\Bundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\Service\ShipmentService;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ShipmentServiceTest extends TestCase
{
    private Shipment $shipment;

    protected function setUp(): void
    {
        $this->shipment = new Shipment(
            'John Doe',
            null,
            'Main Street',
            '42',
            '12345',
            'Metropolis',
            'NL',
            null,
            null,
            1.0
        );
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
}
