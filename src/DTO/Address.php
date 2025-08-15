<?php

namespace Sendcloud\Bundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class Address
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank(allowNull: true)]
    public ?string $companyName;

    #[Assert\NotBlank]
    public string $address;

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

    public function __construct(
        string $name,
        ?string $companyName,
        string $address,
        string $houseNumber,
        string $postalCode,
        string $city,
        string $country,
        ?string $email,
        ?string $phone,
    ) {
        $this->name = $name;
        $this->companyName = $companyName;
        $this->address = $address;
        $this->houseNumber = $houseNumber;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'company_name' => $this->companyName,
            'address_line_1' => $this->address,
            'house_number' => $this->houseNumber,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'country_code' => $this->country,
            'email' => $this->email,
            'phone_number' => $this->phone,
        ], static fn ($value) => null !== $value);
    }
}
