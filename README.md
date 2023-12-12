# PHP Mapbox API
[![CI](https://github.com/liamclaridge444/php-mapbox-api/actions/workflows/ci.yml/badge.svg)](https://github.com/liamclaridge444/php-mapbox-api/actions/workflows/ci.yml)

A wrapper for the Mapbox API, written in PHP.

Inspiration for this project was taken from [KnpLabs/php-github-api](https://github.com/KnpLabs/php-github-api).

## Installation
You can install the package via `composer require` command:

```shell
composer require liamclaridge444/php-mapbox-api
```

Or simply add it to your composer.json dependences and run `composer update`:

```json
"require": {
    "liamclaridge444/php-mapbox-api": "^1.0"
}
```

## Usage
```php
$accessToken = 'your-access-token';

$client = new Mapbox($accessToken);

```
