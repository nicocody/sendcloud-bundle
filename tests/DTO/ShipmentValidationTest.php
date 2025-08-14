<?php

namespace Sendcloud\Bundle\Tests\DTO;

use PHPUnit\Framework\TestCase;
use Sendcloud\Bundle\DTO\Shipment;
use Symfony\Component\Validator\Validation;

class ShipmentValidationTest extends TestCase
{
    public function testValidationAllowsNullOptionalFields(): void
    {
        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
        $shipment = new Shipment(
            'John Doe',
            null,
            'Main Street',
            '42',
            '12345',
            'Metropolis',
            'NL',
            null,
            null,
            1.0
        );

        $violations = $validator->validate($shipment);

        self::assertCount(0, $violations);
    }
}
