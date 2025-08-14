<?php

namespace Sendcloud\Bundle\Tests\DTO;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Shipment;

class ShipmentTest extends TestCase
{
    public function testToArrayReturnsCorrectStructure(): void
    {
        $shipment = new Shipment(
            'John Doe',
            'Acme Inc',
            'Main Street',
            '42',
            '12345',
            'Metropolis',
            'NL',
            'john@example.com',
            '+31612345678',
            1.5
        );

        $expected = [
            'name' => 'John Doe',
            'company_name' => 'Acme Inc',
            'address' => 'Main Street',
            'house_number' => '42',
            'postal_code' => '12345',
            'city' => 'Metropolis',
            'country' => 'NL',
            'email' => 'john@example.com',
            'telephone' => '+31612345678',
            'weight' => 1.5,
        ];

        self::assertSame($expected, $shipment->toArray());
    }
}
