<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ApplicationResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get all applications.
     */
    public function findAll(): array
    {
        return $this->client->get('rest/application');
    }

    /**
     * Get a specific application by ID.
     */
    public function find(int $applicationId): array
    {
        return $this->client->get("rest/application/{$applicationId}");
    }

    /**
     * Get applications filtered by tag name.
     */
    public function findByTag(string $tagName): array
    {
        $applications = $this->findAll();

        return array_filter($applications, function($app) use ($tagName) {
            foreach ($app['tags'] ?? [] as $tag) {
                if ($tag['name'] === $tagName) {
                    return true;
                }
            }
            return false;
        });
    }

    /**
     * Get applications filtered by name (partial match).
     */
    public function findByName(string $name): array
    {
        $applications = $this->findAll();

        return array_filter($applications, function($app) use ($name) {
            return stripos($app['name'], $name) !== false;
        });
    }

    /**
     * Get only visible (non-hidden) applications.
     */
    public function findVisible(): array
    {
        $applications = $this->findAll();

        return array_filter($applications, function($app) {
            return !($app['hidden'] ?? false);
        });
    }

    /**
     * Get metadata/datastores for a specific application.
     * Returns the list of datastores associated with this application.
     *
     * @param int $applicationId The FormServices application ID
     * @return array The datastores metadata
     */
    public function getMetadata(int $applicationId): array
    {
        return $this->client->get("rest/application/{$applicationId}/ds");
    }

    /**
     * Alias for getMetadata() - more explicit name.
     */
    public function getDatastores(int $applicationId): array
    {
        return $this->getMetadata($applicationId);
    }
}
