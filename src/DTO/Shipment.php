<?php

namespace Sendcloud\Bundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Shipment
{
    #[Assert\Valid]
    public Address $toAddress;

    #[Assert\Valid]
    public Address $fromAddress;

    /**
     * @var Parcel[]
     */
    #[Assert\Valid]
    public array $parcels;

    /**
     * @var array{type:string}
     */
    public array $shipWith;

    /**
     * @param Parcel[] $parcels
     * @param array{type:string} $shipWith
     */
    public function __construct(Address $toAddress, Address $fromAddress, array $parcels, array $shipWith = ['type' => 'sendcloud:letter'])
    {
        $this->toAddress = $toAddress;
        $this->fromAddress = $fromAddress;
        $this->parcels = $parcels;
        $this->shipWith = $shipWith;
    }

    public function toArray(): array
    {
        return [
            'to_address' => $this->toAddress->toArray(),
            'from_address' => $this->fromAddress->toArray(),
            'parcels' => array_map(static fn(Parcel $parcel) => $parcel->toArray(), $this->parcels),
            'ship_with' => $this->shipWith,
        ];
    }
}
