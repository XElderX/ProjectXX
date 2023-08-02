<?php

// app/Providers/TimezonesServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TimezonesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/timezones.php' => config_path('timezones.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/timezones.php', 'timezones'
        );
    }
}

