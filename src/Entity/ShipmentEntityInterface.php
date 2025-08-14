<?php

namespace Sendcloud\Bundle\Entity;

use Sendcloud\Bundle\DTO\Address;

interface ShipmentEntityInterface
{
    public function getToAddress(): Address;
    public function getFromAddress(): Address;
    public function getWeight(): float;
}
