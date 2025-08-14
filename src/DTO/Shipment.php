<?php

namespace Sendcloud\Bundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Shipment
{
    #[Assert\Valid]
    public Address $toAddress;

    #[Assert\Valid]
    public Address $fromAddress;

    #[Assert\Positive]
    public float $weight;

    public function __construct(Address $toAddress, Address $fromAddress, float $weight)
    {
        $this->toAddress = $toAddress;
        $this->fromAddress = $fromAddress;
        $this->weight = $weight;
    }

    public function toArray(): array
    {
        return [
            'to_address' => $this->toAddress->toArray(),
            'from_address' => $this->fromAddress->toArray(),
            'weight' => $this->weight,
        ];
    }
}
