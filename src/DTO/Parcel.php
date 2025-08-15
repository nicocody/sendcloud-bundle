<?php

namespace Sendcloud\Bundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Parcel
{
    /**
     * @var array{value: float, unit: string}
     */
    #[Assert\Collection(fields: [
        'value' => [new Assert\Required(), new Assert\Positive()],
        'unit' => [new Assert\Required(), new Assert\NotBlank()],
    ])]
    public array $weight;

    public function __construct(float $value, string $unit = 'kg')
    {
        $this->weight = [
            'value' => $value,
            'unit' => $unit,
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'weight' => $this->weight,
        ], static fn ($value) => null !== $value);
    }
}
