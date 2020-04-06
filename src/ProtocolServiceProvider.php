<?php

namespace JSefton\Protocol;

use Illuminate\Support\ServiceProvider;

class ProtocolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Configuration
        $this->publishes([
            __DIR__.'/../config/' => config_path(),
        ], 'protocol.config');

        $this->handle();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Main method to process config and
     * handle what you want to do
     */
    public function handle()
    {
        $config = config('protocol');
        $protocol = self::detectProtocol();
        if ($config['auto'] == true) {
            // Automatically handle based on current protocol
            if ($protocol == 'https') {
                \URL::forceScheme('https');
            }
        } elseif ($config['protocol'] !== '') {
            // Force everything to set protocol
            \URL::forceScheme($config['protocol']);
            if ($protocol !== $config['protocol']) {
                // redirect to set protocol;
                self::redirectToProtocol($config['protocol']);
            }
        } else {
            $this->handleEnvironments();
        }
    }

    /**
     * Redirect current location to correct protocol
     * @param $protocol
     */
    public static function redirectToProtocol($protocol)
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $redirect = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('Location: ' . $redirect);
        }
    }

    /**
     * Check config for the current environment and
     * force internal links to https if set
     */
    public function handleEnvironments()
    {
        $env = \App::environment();
        if ($config = config('protocol.environments.' . $env)) {
            $protocol = self::detectProtocol();
            if ($config['https']) {
                \URL::forceScheme('https');
            }

            if ($config['redirect'] && $config['https']) {
                if ($protocol !== 'https') {
                    self::redirectToProtocol('https');
                }
            }
        }
    }

    /**
     * Try our best to detect if its really https. Supports forward
     * protocol if behind load balancing and CloudFront headers.
     * Falls back to the most basic form of knowing by port.
     * @return string
     */
    public static function detectProtocol()
    {
        $protocol = 'http';
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == "https") {
                $protocol = 'https';
            } else if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'])) {
                if ($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] == "https") {
                    $protocol = 'https';
                }
            }
        } else if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'])) {
            if ($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] == "https") {
                $protocol = 'https';
            }
        } else if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $protocol = 'https';
        } else if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
            $protocol = 'https';
        }

        return $protocol;
    }
}
