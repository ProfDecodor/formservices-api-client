<?php

namespace Jway\FormServicesApiClient;

use InvalidArgumentException;
use Jway\FormServicesApiClient\Api\Contracts\ApiClientInterface;

class ClientFactory
{
    protected array $clients = [];
    protected array $apiClients = [];
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get a client instance by name.
     */
    public function client(?string $name = null): FormServicesClient
    {
        $name = $name ?? $this->getDefaultClient();

        if (!isset($this->clients[$name])) {
            $this->clients[$name] = $this->createClient($name);
        }

        return $this->clients[$name];
    }

    /**
     * Get a versioned API client instance.
     */
    public function api(?string $name = null, ?string $version = null): ApiClientInterface
    {
        $name = $name ?? $this->getDefaultClient();
        $config = $this->getClientConfig($name);
        $version = $version ?? $config['api_version'] ?? '2023';

        $cacheKey = "{$name}:{$version}";

        if (!isset($this->apiClients[$cacheKey])) {
            $this->apiClients[$cacheKey] = $this->createApiClient($name, $version);
        }

        return $this->apiClients[$cacheKey];
    }

    /**
     * Create a new client instance.
     */
    protected function createClient(string $name): FormServicesClient
    {
        $config = $this->getClientConfig($name);

        return new FormServicesClient(
            $config['base_url'],
            $config['login'] ?? '',
            $config['api_key'] ?? '',
            $config['timeout'] ?? 30,
            $config['verify_ssl'] ?? true
        );
    }

    /**
     * Get the configuration for a specific client.
     */
    protected function getClientConfig(string $name): array
    {
        if (!isset($this->config['clients'][$name])) {
            throw new InvalidArgumentException("Client [{$name}] is not configured.");
        }

        return $this->config['clients'][$name];
    }

    /**
     * Get the default client name.
     */
    protected function getDefaultClient(): string
    {
        return $this->config['default'] ?? 'main';
    }

    /**
     * Get all configured client names.
     */
    public function getAvailableClients(): array
    {
        return array_keys($this->config['clients'] ?? []);
    }

    /**
     * Check if a client is configured.
     */
    public function hasClient(string $name): bool
    {
        return isset($this->config['clients'][$name]);
    }

    /**
     * Create a versioned API client instance.
     */
    protected function createApiClient(string $name, string $version): ApiClientInterface
    {
        $httpClient = $this->client($name);

        $apiClass = "Jway\\FormServicesApiClient\\Api\\V{$version}\\FormServicesApi";

        if (!class_exists($apiClass)) {
            throw new InvalidArgumentException("API version [{$version}] is not supported.");
        }

        return new $apiClass($httpClient);
    }

    /**
     * Get available API versions.
     */
    public function getAvailableVersions(): array
    {
        return ['2023']; // Will be expanded with future versions
    }
}
