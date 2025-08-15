<?php

namespace Sendcloud\Bundle\Factory;

use Sendcloud\Bundle\DTO\Shipment;
use Sendcloud\Bundle\Entity\ShipmentEntityInterface;

class ShipmentDtoFactory
{
    public function createFromEntity(ShipmentEntityInterface $entity): Shipment
    {
        return new Shipment(
            $entity->getToAddress(),
            $entity->getFromAddress(),
            $entity->getParcels(),
            $entity->getShipWith(),
        );
    }
}
