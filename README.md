# Pretty Routes for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wulfheart/pretty_routes.svg?style=flat-square)](https://packagist.org/packages/wulfheart/pretty_routes)
[![Total Downloads](https://img.shields.io/packagist/dt/wulfheart/pretty_routes.svg?style=flat-square)](https://packagist.org/packages/wulfheart/pretty_routes)

Display your Laravel routes in the console, but make it pretty. 😎

<img src="https://user-images.githubusercontent.com/25671390/116441604-e0aa3300-a851-11eb-9e98-a59ff356c9dc.png"/>

## Installation

You can install the package via composer:

```bash
composer require wulfheart/pretty_routes
```

## Usage

```bash
php artisan route:pretty
```
or

```bash
php artisan route:pretty --except-path=horizon --method=POST --reverse
php artisan route:pretty --only-path=app --method=POST --reverse
php artisan route:pretty --only-name=app --method=POST 
php artisan route:pretty --only-name=app --method=POST --group=path --reverse-group
php artisan route:pretty --only-name=app,horizon,debugbar --except-path=foo,bar --group=name --reverse
```

## Advanced Example

<img src="https://user-images.githubusercontent.com/25671390/116859537-6cc8ab80-ac00-11eb-9376-e6baee12ace8.png"/>

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Feel free to open an issue or a PR. Discussions are disabled right now as there shouldn't be too much need for discussion and it can happen in the issues.

## Credits

- [Alexander Wulf](https://github.com/Wulfheart)
- [Tom Witkowski](https://github.com/Gummibeer)
- [Matt Staufer](https://github.com/mattstauffer)
- [Bhushan Gaikwad](https://github.com/bhushan)
- [Edward Akerboom](https://github.com/infostreams)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
