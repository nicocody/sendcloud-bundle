# Sendcloud Bundle

Symfony bundle to integrate with the Sendcloud API (v3). PHP 8.3+ required.

## Installation

Install the bundle with Composer:

```bash
composer require app/sendcloud-bundle
```

If Symfony Flex is not installed, enable the bundle in `config/bundles.php`:

```php
return [
    Sendcloud\Bundle\SendcloudBundle::class => ['all' => true],
];
```

## Configuration

Add your Sendcloud API credentials to `config/packages/sendcloud.yaml`:

```yaml
sendcloud:
  api_key: '%env(SENDCLOUD_API_KEY)%'
  api_secret: '%env(SENDCLOUD_API_SECRET)%'
  # base_url is optional and defaults to https://panel.sendcloud.sc/api/v3
  # base_url: 'https://panel.sendcloud.sc/api/v3'
```

Set the `SENDCLOUD_API_KEY` and `SENDCLOUD_API_SECRET` environment variables in your `.env` files or server configuration.

## Usage

Implement `Sendcloud\\Bundle\\Entity\\ShipmentEntityInterface` on the entity that holds shipment data in your project. Then inject the `Sendcloud\\Bundle\\Service\\ShipmentService` and `Sendcloud\\Bundle\\Factory\\ShipmentDtoFactory` into your services:

```php
$dto = $shipmentDtoFactory->createFromEntity($yourEntity);
$response = $shipmentService->announceShipment($dto);
```
