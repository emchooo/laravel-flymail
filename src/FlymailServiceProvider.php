<?php

namespace Emchooo\Flymail;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Emchooo\Flymail\Flymail;
use Illuminate\Support\ServiceProvider;

class FlymailServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->extend('mailer', function ($mailer, $app) {
            return new Flymail(
                $app['view'],
                $app['swift.mailer'],
                $app['events']
            );
        });
    }
}
