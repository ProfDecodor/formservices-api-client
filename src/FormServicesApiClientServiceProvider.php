<?php

namespace Jway\FormServicesApiClient;

use Illuminate\Support\ServiceProvider;

class FormServicesApiClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/formservices-api-client.php',
            'formservices-api-client'
        );

        // Register the ClientFactory as a singleton
        $this->app->singleton('formservices-client-factory', function ($app) {
            return new ClientFactory(config('formservices-api-client'));
        });

        // Register the default client as a singleton
        $this->app->singleton('formservices-client', function ($app) {
            return $app->make('formservices-client-factory')->client();
        });

        // Bind the ClientFactory class
        $this->app->bind(ClientFactory::class, function ($app) {
            return $app->make('formservices-client-factory');
        });

        // Bind the FormServicesClient class (returns default client)
        $this->app->bind(FormServicesClient::class, function ($app) {
            return $app->make('formservices-client');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration file
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/formservices-api-client.php' => config_path('formservices-api-client.php'),
            ], 'config');

            // Publish migrations if needed
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');

            // Publish views if needed
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/formservices-api-client'),
            ], 'views');
        }

        // Load routes if needed
        // $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        // Load views if needed
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'formservices-api-client');

        // Load migrations if needed
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
