


# Zoho all in one for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alimehraei/zoho-v4.svg?style=flat-square)](https://packagist.org/packages/alimehraei/zoho-v4)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/alimehraei/zoho-v4/run-tests?label=tests)](https://github.com/alimehraei/zoho-v4/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/alimehraei/zoho-v4/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/alimehraei/zoho-v4/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alimehraei/zoho-v4.svg?style=flat-square)](https://packagist.org/packages/alimehraei/zoho-v4)

Laravel Package for integration ZOHO version 3 API.

## Installation

You can install the package via composer:

```bash
composer require alimehraei/zoho-v4
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="zoho-v4-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="zoho-v4-config"
```

This is the contents of the published config file:

```php
return [
];
```

<!-- ## Usage

```php
$zohoAllInOne = new alimehraei\ZohoAllInOne();
echo $zohoAllInOne->echoPhrase('Hello, alimehraei!');
``` -->

<!-- ## Testing

```bash
composer test
``` -->

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mohammad Sadegh Maleki](https://github.com/alimehraei)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
