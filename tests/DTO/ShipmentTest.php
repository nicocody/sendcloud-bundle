<?php

namespace Sendcloud\Bundle\Tests\DTO;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Address;
use Sendcloud\Bundle\DTO\Shipment;

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

        $shipment = new Shipment($to, $from, 1.5);

        $expected = [
            'to_address' => $to->toArray(),
            'from_address' => $from->toArray(),
            'weight' => 1.5,
        ];

        self::assertSame($expected, $shipment->toArray());
    }
}
