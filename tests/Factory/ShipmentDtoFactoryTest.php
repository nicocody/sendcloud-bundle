<?php

namespace Sendcloud\Bundle\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\Entity\ShipmentEntityInterface;
use Sendcloud\Bundle\Factory\ShipmentDtoFactory;

class ShipmentDtoFactoryTest extends TestCase
{
    public function testCreateFromEntityBuildsShipmentDto(): void
    {
        $entity = new class() implements ShipmentEntityInterface {
            public function getName(): string { return 'Jane Doe'; }
            public function getCompanyName(): ?string { return 'Widgets'; }
            public function getStreet(): string { return 'Elm Street'; }
            public function getHouseNumber(): string { return '13'; }
            public function getPostalCode(): string { return '54321'; }
            public function getCity(): string { return 'Gotham'; }
            public function getCountry(): string { return 'US'; }
            public function getEmail(): ?string { return 'jane@example.com'; }
            public function getPhone(): ?string { return null; }
            public function getWeight(): float { return 2.0; }
        };

        $factory = new ShipmentDtoFactory();
        $shipment = $factory->createFromEntity($entity);

        self::assertInstanceOf(Shipment::class, $shipment);
        self::assertSame('Jane Doe', $shipment->name);
        self::assertSame('Widgets', $shipment->companyName);
        self::assertSame('Elm Street', $shipment->street);
        self::assertSame('13', $shipment->houseNumber);
        self::assertSame('54321', $shipment->postalCode);
        self::assertSame('Gotham', $shipment->city);
        self::assertSame('US', $shipment->country);
        self::assertSame('jane@example.com', $shipment->email);
        self::assertNull($shipment->phone);
        self::assertSame(2.0, $shipment->weight);
    }
}
