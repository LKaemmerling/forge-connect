# Forge Connect Test
[![StyleCI](https://styleci.io/repos/75338534/shield?branch=master)](https://styleci.io/repos/75338534)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/cd4cd41e-5fd9-4f89-9c4a-d330a658f75a/small.png)](https://insight.sensiolabs.com/projects/cd4cd41e-5fd9-4f89-9c4a-d330a658f75a)
This is an CLI Tool to easily connect to your Servers from [Forge](https://forge.laravel.com). Actually it is Mac Only!
## Installation

```bash
composer global require lkdev/forge-connect
```

Than simply run to register your Forge Credentials. There will be encrypted and saved. You must define your own Passphrase
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
