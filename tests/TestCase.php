<?php

namespace Jway\FormServicesApiClient\Tests;

use Jway\FormServicesApiClient\FormServicesApiClientServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            FormServicesApiClientServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'FormServicesClient' => \Jway\FormServicesApiClient\Facades\FormServicesClient::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Setup multi-client configuration
        $app['config']->set('formservices-api-client.default', 'main');
        $app['config']->set('formservices-api-client.clients', [
            'main' => [
                'base_url' => 'https://test.api.com',
                'login' => 'test-login',
                'api_key' => 'test-api-key',
                'timeout' => 30,
            ],
            'secondary' => [
                'base_url' => 'https://secondary.api.com',
                'login' => 'secondary-login',
                'api_key' => 'secondary-api-key',
                'timeout' => 60,
            ],
        ]);
    }
}