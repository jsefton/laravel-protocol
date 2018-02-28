# Laravel Protocol
Handles detection of http protocol and changes internal links and redirects to match.

### Installation

You will need composer to install this package (get composer). Then run:

```bash
composer require jsefton/laravel-protocol
```

#### Register Service Provider

Add the below into your `config/app.php` within `providers` array

```
JSefton\Protocol\ProtocolServiceProvider::class
```

After installation you will need to publish the config file. To do this run:

```bash
php artisan vendor:publish --tag=protocol
```

This will create the file `config/protocol.php` where you can configure the settings.
