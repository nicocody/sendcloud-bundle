<?php

namespace Sendcloud\Bundle\Tests\DTO;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Address;
use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\DTO\Parcel;

class ShipmentTest extends TestCase
{
    public function testToArrayReturnsCorrectStructure(): void
    {
        $to = new Address(
            'John Doe',
            'Acme Inc',
            'Main Street',
            '42',
            '12345',
            'Metropolis',
            'NL',
            'john@example.com',
            '+31612345678'
        );

        $from = new Address(
            'Jane Sender',
            'Widgets',
            'Elm Street',
            '13',
            '54321',
            'Gotham',
            'US',
            'jane@example.com',
            null
        );

        $parcel = new Parcel(1.5);
        $shipment = new Shipment($to, $from, [$parcel]);

        $expected = [
            'to_address' => $to->toArray(),
            'from_address' => $from->toArray(),
            'parcels' => [
                ['weight' => 1.5],
            ],
            'ship_with' => ['type' => 'sendcloud:letter'],
        ];

        self::assertSame($expected, $shipment->toArray());
    }
}
