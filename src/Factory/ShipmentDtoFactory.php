<?php

namespace Sendcloud\Bundle\Factory;

use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\Entity\ShipmentEntityInterface;

class ShipmentDtoFactory
{
    public function createFromEntity(ShipmentEntityInterface $entity): Shipment
    {
        return new Shipment(
            $entity->getName(),
            $entity->getCompanyName(),
            $entity->getStreet(),
            $entity->getHouseNumber(),
            $entity->getPostalCode(),
            $entity->getCity(),
            $entity->getCountry(),
            $entity->getEmail(),
            $entity->getPhone(),
            $entity->getWeight()
        );
    }
}

