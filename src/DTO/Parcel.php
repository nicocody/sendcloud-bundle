<?php

namespace Sendcloud\Bundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Parcel
{
    #[Assert\Positive]
    public float $weight;

    public function __construct(float $weight)
    {
        $this->weight = $weight;
    }

    public function toArray(): array
    {
        return array_filter([
            'weight' => $this->weight,
        ], static fn ($value) => null !== $value);
    }
}
