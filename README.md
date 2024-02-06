# PHP Mapbox API
[![CI](https://github.com/liamclaridge444/php-mapbox-api/actions/workflows/ci.yml/badge.svg)](https://github.com/liamclaridge444/php-mapbox-api/actions/workflows/ci.yml) [![codecov](https://codecov.io/gh/liamclaridge444/php-mapbox-api/graph/badge.svg?token=VOKUQBV77A)](https://codecov.io/gh/liamclaridge444/php-mapbox-api)

An easy to use wrapper for the Mapbox API, written in PHP.

Inspiration for this project was taken from [KnpLabs/php-github-api](https://github.com/KnpLabs/php-github-api).

## Requirements
- PHP ^8.1
- A [PSR-17 implementation](https://packagist.org/providers/psr/http-factory-implementation)
- A [PSR-18 implementation](https://packagist.org/providers/psr/http-client-implementation)

## Installation
You can install the package via the `composer require` command:

```shell
composer require liamclaridge444/php-mapbox-api
```

## Usage

Instantiate a Mapbox client with your access token, then chain the API name and method (see example below).

```php
$accessToken = 'your-access-token';

$client = new Mapbox($accessToken);

$response = $client->datasets()->list();

```
