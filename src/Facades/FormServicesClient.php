<?php

namespace Jway\FormServicesApiClient\Facades;

use Illuminate\Support\Facades\Facade;
use Jway\FormServicesApiClient\FormServicesClient as Client;

/**
 * @method static Client client(string|null $name = null)
 * @method static array get(string $endpoint, array $params = [])
 * @method static array post(string $endpoint, array $data = [])
 * @method static array put(string $endpoint, array $data = [])
 * @method static array delete(string $endpoint)
 * @method static array getAvailableClients()
 * @method static bool hasClient(string $name)
 * @method static string getLogin()
 * @method static string getBaseUrl()
 *
 * @see \Jway\FormServicesApiClient\ClientFactory
 */
class FormServicesClient extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'formservices-client-factory';
    }

    /**
     * Get the default client instance.
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();

        // If calling methods that exist on ClientFactory, use factory
        if (method_exists($instance, $method)) {
            return $instance->$method(...$args);
        }

        // Otherwise, proxy to the default client
        return $instance->client()->$method(...$args);
    }
}