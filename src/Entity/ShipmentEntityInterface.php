<?php

namespace Sendcloud\Bundle\Entity;

use Sendcloud\Bundle\DTO\Address;
use Sendcloud\Bundle\DTO\Parcel;

interface ShipmentEntityInterface
{
    public function getToAddress(): Address;
    public function getFromAddress(): Address;
    /**
     * @return Parcel[]
     */
    public function getParcels(): array;
    /**
     * @return array{type:string}
     */
    public function getShipWith(): array;
}
