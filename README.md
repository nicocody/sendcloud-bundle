# Sendcloud Bundle

Symfony bundle to integrate with the Sendcloud API (v3). PHP 8.3+ required.

## Usage

Configure the bundle with your API credentials and implement
`Sendcloud\\Bundle\\Entity\\ShipmentEntityInterface` on the entity that
holds shipment data in your project.

```php
$dto = $shipmentDtoFactory->createFromEntity($yourEntity);
$response = $shipmentService->announceShipment($dto);
```
