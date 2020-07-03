<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 18-12-7
 * description:
 */


namespace Waimao\LaravelAi;

use Athlon18\AI\AI;
use Athlon18\AI\DriverFactory;
use Illuminate\Support\ServiceProvider;


class AiServiceProvider extends ServiceProvider
{


    public function boot()
    {
        $this->publishes([
            dirname(__DIR__) . '/config/laravel-ai.php' => config_path('ai.php'),
        ]);
    }


    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/laravel-ai.php',
            'ai'
        );


        $this->app->singleton('ai.factory', function ($app) {
            return new DriverFactory();
        });

        $this->app->singleton('ai', function ($app) {
            return new AiManager($app, $app['ai.factory']);
        });

        $this->app->singleton('ai.default', function ($app) {
            return $app['ai']->driver();
        });
    }
}
