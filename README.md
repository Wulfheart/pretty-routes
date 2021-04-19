# This is my package PrettyRoutes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wulfheart/pretty_routes.svg?style=flat-square)](https://packagist.org/packages/wulfheart/pretty_routes)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/wulfheart/pretty_routes/run-tests?label=tests)](https://github.com/wulfheart/pretty_routes/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/wulfheart/pretty_routes/Check%20&%20fix%20styling?label=code%20style)](https://github.com/wulfheart/pretty_routes/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/wulfheart/pretty_routes.svg?style=flat-square)](https://packagist.org/packages/wulfheart/pretty_routes)

[](delete) 1) manually replace `Alexander Wulf, Wulfheart, auhor@domain.com, Wulfheart, wulfheart, Vendor Name, pretty-routes, pretty_routes, pretty_routes, PrettyRoutes, This is my package PrettyRoutes` with their correct values
[](delete) in `CHANGELOG.md, LICENSE.md, README.md, ExampleTest.php, ModelFactory.php, PrettyRoutes.php, PrettyRoutesCommand.php, PrettyRoutesFacade.php, PrettyRoutesServiceProvider.php, TestCase.php, composer.json, create_pretty_routes_table.php.stub`
[](delete) and delete `configure-pretty_routes.sh`

[](delete) 2) You can also run `./configure-pretty_routes.sh` to do this automatically.

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-pretty_routes-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-pretty_routes-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require wulfheart/pretty_routes
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider" --tag="pretty_routes-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Wulfheart\PrettyRoutes\PrettyRoutesServiceProvider" --tag="pretty_routes-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$pretty_routes = new Wulfheart\PrettyRoutes();
echo $pretty_routes->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Alexander Wulf](https://github.com/Wulfheart)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
