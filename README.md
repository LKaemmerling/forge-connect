# Forge Connect
[![StyleCI](https://styleci.io/repos/74739793/shield?branch=master)](https://styleci.io/repos/74739793)
[![Latest Stable Version](https://poser.pugx.org/lkdev/laravel-uptime-monitor-api/v/stable)](https://packagist.org/packages/lkdev/laravel-uptime-monitor-api)
[![Total Downloads](https://poser.pugx.org/lkdev/laravel-uptime-monitor-api/downloads)](https://packagist.org/packages/lkdev/laravel-uptime-monitor-api)
[![License](https://poser.pugx.org/lkdev/laravel-uptime-monitor-api/license)](https://packagist.org/packages/lkdev/laravel-uptime-monitor-api)

This is an CLI Tool to easily connect to your Servers from [Forge](https://forge.laravel.com). Actually it is Mac Only!
## Installation

```bash
composer global require lkdev/forge-connect
```

Than simply run:
```bash
forge-connect register [YourForgeEMail] [YourForgePassword]
```
And now you can list all your Servers with:
```bash
forge-connect servers:list
```

And if you want to connect per SSH to one of your servers:
```bash
forge-connect connect [NameOfYourServerFromForge]
```
## Documentation

You can find the Documentation [here](http://lk-development.de/docs/laravel-uptime-monitor-api-v1/).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email kontakt@lukas-kaemmerling.de instead of using the issue tracker.

## Credits

- [Lukas Kämmerling](https://github.com/LKDevelopment)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
