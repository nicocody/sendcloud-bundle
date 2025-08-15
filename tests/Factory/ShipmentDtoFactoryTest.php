<?php

namespace Sendcloud\Bundle\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Address;
use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\DTO\Parcel;
use Sendcloud\Bundle\Entity\ShipmentEntityInterface;
use Sendcloud\Bundle\Factory\ShipmentDtoFactory;

class ShipmentDtoFactoryTest extends TestCase
{
    public function testCreateFromEntityBuildsShipmentDto(): void
    {
        $entity = new class() implements ShipmentEntityInterface {
            public function getToAddress(): Address {
                return new Address('Jane Doe', 'Widgets', 'Elm Street', '13', '54321', 'Gotham', 'US', 'jane@example.com', null);
            }
            public function getFromAddress(): Address {
                return new Address('Sender', null, 'Main Street', '1', '12345', 'Metropolis', 'NL', null, '+31612345678');
            }
            public function getParcels(): array { return [new Parcel(2.0)]; }
            public function getShipWith(): array { return ['type' => 'sendcloud:letter']; }
        };

        $factory = new ShipmentDtoFactory();
        $shipment = $factory->createFromEntity($entity);

        self::assertInstanceOf(Shipment::class, $shipment);
        self::assertSame('Jane Doe', $shipment->toAddress->name);
        self::assertSame('Sender', $shipment->fromAddress->name);
        self::assertSame(2.0, $shipment->parcels[0]->weight['value']);
        self::assertSame('kg', $shipment->parcels[0]->weight['unit']);
        self::assertSame('sendcloud:letter', $shipment->shipWith['type']);
    }
}
