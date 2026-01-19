<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ContentResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Find all contents.
     */
    public function findAll(string $type, ?string $name = null, ?string $query = null): array
    {
        return $this->client->get('rest/content', [
            'type' => $type,
            'name' => $name,
            'query' => $query,
        ]);
    }

    /**
     * Find specified content.
     */
    public function find(int $contentId): array
    {
        return $this->client->get("rest/content/{$contentId}");
    }

    /**
     * Create a new content with the attached ZIP/JZIP file.
     */
    public function importZip(array $data): array
    {
        // This is multipart/form-data, users can use the HTTP client directly
        return $this->client->post('rest/content', $data);
    }

    /**
     * Update a content.
     */
    public function update(int $contentId, array $contentData): array
    {
        return $this->client->put("rest/content/{$contentId}", $contentData);
    }

    /**
     * Delete a content.
     */
    public function delete(int $contentId): array
    {
        return $this->client->delete("rest/content/{$contentId}");
    }

    /**
     * Duplicate a content.
     */
    public function duplicate(int $contentId, array $metadata): array
    {
        return $this->client->post("rest/content/{$contentId}/duplicate", $metadata);
    }

    /**
     * Export content.
     */
    public function export(int $contentId): array
    {
        return $this->client->get("rest/content/{$contentId}/export");
    }

    /**
     * Finalize content version.
     */
    public function finalizeVersion(int $contentId): array
    {
        return $this->client->put("rest/content/{$contentId}/finalize", []);
    }

    /**
     * Write the content on server filesystem.
     */
    public function prepare(int $contentId, bool $withSubContents = false): array
    {
        return $this->client->get("rest/content/{$contentId}/prepare", [
            'withSubContents' => $withSubContents,
        ]);
    }

    /**
     * Access to content access management.
     */
    public function accesses(): ContentAccessResource
    {
        return new ContentAccessResource($this->client);
    }

    /**
     * Access to content file management.
     */
    public function files(): ContentFileResource
    {
        return new ContentFileResource($this->client);
    }

    /**
     * Access to content repository management.
     */
    public function repositories(): ContentRepositoryResource
    {
        return new ContentRepositoryResource($this->client);
    }

    /**
     * Access to content translation management.
     */
    public function translations(): ContentTranslationResource
    {
        return new ContentTranslationResource($this->client);
    }

    /**
     * Access to content sub-content management.
     */
    public function subContents(): ContentSubContentResource
    {
        return new ContentSubContentResource($this->client);
    }
}