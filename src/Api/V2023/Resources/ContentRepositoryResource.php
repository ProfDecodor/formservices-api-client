<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ContentRepositoryResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Find all repositories for a content.
     */
    public function findAll(int $contentId): array
    {
        return $this->client->get("rest/content/{$contentId}/repository");
    }

    /**
     * Add a content repository.
     */
    public function create(int $contentId, array $repositoryData): array
    {
        return $this->client->post("rest/content/{$contentId}/repository", $repositoryData);
    }

    /**
     * Update a repository.
     */
    public function update(int $contentId, string $repositoryName, array $repositoryData): array
    {
        return $this->client->put("rest/content/{$contentId}/repository/{$repositoryName}", $repositoryData);
    }

    /**
     * Delete a content repository.
     */
    public function delete(int $contentId, string $repositoryName): array
    {
        return $this->client->delete("rest/content/{$contentId}/repository/{$repositoryName}");
    }

    /**
     * Get differences with a repository.
     */
    public function diff(int $contentId, string $repositoryName): array
    {
        return $this->client->post("rest/content/{$contentId}/repository/{$repositoryName}/diff", []);
    }

    /**
     * Import from a repository.
     */
    public function import(int $contentId, string $repositoryName, array $repositoryData, ?string $type = null): array
    {
        return $this->client->post(
            "rest/content/{$contentId}/repository/{$repositoryName}/import",
            $repositoryData,
            ['type' => $type]
        );
    }

    /**
     * Pull from a repository.
     */
    public function pull(int $contentId, string $repositoryName): array
    {
        return $this->client->post("rest/content/{$contentId}/repository/{$repositoryName}/pull", []);
    }

    /**
     * Push to a repository.
     */
    public function push(int $contentId, string $repositoryName, ?string $message = null): array
    {
        return $this->client->post("rest/content/{$contentId}/repository/{$repositoryName}/push", [
            'message' => $message,
        ]);
    }

    /**
     * Find possible repositories.
     */
    public function findOptions(int $contentId): array
    {
        return $this->client->get("rest/content/{$contentId}/repository-options");
    }
}