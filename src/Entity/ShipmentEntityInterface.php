<?php

namespace Sendcloud\Bundle\Entity;

interface ShipmentEntityInterface
{
    public function getName(): string;
    public function getCompanyName(): ?string;
    public function getStreet(): string;
    public function getHouseNumber(): string;
    public function getPostalCode(): string;
    public function getCity(): string;
    public function getCountry(): string;
    public function getEmail(): ?string;
    public function getPhone(): ?string;
    public function getWeight(): float;
}

