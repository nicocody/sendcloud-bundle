<?php

namespace Sendcloud\Bundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Shipment
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank(allowNull: true)]
    public ?string $companyName;

    #[Assert\NotBlank]
    public string $street;

    #[Assert\NotBlank]
    public string $houseNumber;

    #[Assert\NotBlank]
    public string $postalCode;

    #[Assert\NotBlank]
    public string $city;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 2)]
    public string $country;

    #[Assert\Email]
    public ?string $email;

    #[Assert\NotBlank(allowNull: true)]
    public ?string $phone;

    #[Assert\Positive]
    public float $weight;

    public function __construct(
        string $name,
        ?string $companyName,
        string $street,
        string $houseNumber,
        string $postalCode,
        string $city,
        string $country,
        ?string $email,
        ?string $phone,
        float $weight
    ) {
        $this->name = $name;
        $this->companyName = $companyName;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
        $this->email = $email;
        $this->phone = $phone;
        $this->weight = $weight;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'company_name' => $this->companyName,
            'address' => $this->street,
            'house_number' => $this->houseNumber,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'country' => $this->country,
            'email' => $this->email,
            'telephone' => $this->phone,
            'weight' => $this->weight,
        ];
    }
}

