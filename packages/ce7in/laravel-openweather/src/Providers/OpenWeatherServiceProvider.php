<?php

namespace Ce7in\LaravelOpenweather\Providers;

use Ce7in\LaravelOpenweather\OpenWeather;
use Illuminate\Support\ServiceProvider;

class OpenWeatherServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
                             __DIR__ . '/../../config/openweather.php' => config_path('openweather.php'),
                         ], 'config');
    }

    public function register()
    {
        $this->app->singleton(OpenWeather::class, function () {
            return new OpenWeather(config('openweather'));
        });

        $this->app->alias(OpenWeather::class, 'OpenWeather');
    }
}