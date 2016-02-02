<?php

namespace RobbieP\Afterthedeadline;

use Illuminate\Support\ServiceProvider;

class AfterthedeadlineServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/afterthedeadline.php' => config_path('afterthedeadline.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['afterthedeadline'] = $this->app->share(function ($app) {
            return new Afterthedeadline(config('afterthedeadline'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['afterthedeadline'];
    }

    public function getConfig($key)
    {
        return $this->app['config']["robbiep/afterthedeadline::$key"];
    }
}
