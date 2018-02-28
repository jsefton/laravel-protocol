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
php artisan vendor:publish --tag=protocol.config
```

This will create the file `config/protocol.php` where you can configure the settings.

### Configuration

#### `auto`

If set to true this will automatically match the internal links to the current users protocol.

#### `protocol`

If set this will force internal links and redirect users to the set protocol. Accepted values are `http` or `https`. Leave blank to not set.

#### `environments`

You can add your own name for environments within this array. The key of the array should match your used `APP_ENV` values for it to detect correctly.

Within each environment you can set `https` to `true` or `false`. If `true` this will change all internal linking to `https`. If you set `redirect` to `true` then this will force all users to `https`, but only if you have set `https` to `true`.

##### Example Config

```php
/**
 * Automatically detect based on current protocol
 */
'auto' => false,

/**
 * Force everything to a set protocol
 * If blank then won't force anything
 * Ignored it 'auto' is true.
 */
'protocol' => '',

/**
 * Use different rules per environment
 * Ignored if 'auto' is true or 'protocol' is set.
 */
'environments' => [
    'local' => [
        'https' => false,
        'redirect' => false
    ],
    'production' => [
        'https' => true,
        'redirect' => false
    ]
]
```
