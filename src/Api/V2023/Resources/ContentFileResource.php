<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ContentFileResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Find all files in the specified content.
     */
    public function findAll(int $contentId, array $filters = []): array
    {
        return $this->client->get("rest/content/{$contentId}/file", $filters);
    }

    /**
     * Find the corresponding file in the specified content.
     */
    public function find(int $contentId, int $fileId): array
    {
        return $this->client->get("rest/content/{$contentId}/file/{$fileId}");
    }

    /**
     * Create a new file in the specified content.
     * This is a multipart/form-data request.
     */
    public function create(int $contentId, array $fileData): array
    {
        return $this->client->post("rest/content/{$contentId}/file", $fileData);
    }

    /**
     * Update a file from the specified content.
     * This is a multipart/form-data request.
     */
    public function update(int $contentId, int $fileId, array $fileData): array
    {
        return $this->client->put("rest/content/{$contentId}/file/{$fileId}", $fileData);
    }

    /**
     * Update one or more files from the specified content.
     */
    public function updateBatch(int $contentId, array $filesData): array
    {
        return $this->client->put("rest/content/{$contentId}/file", $filesData);
    }

    /**
     * Delete a file from the specified content.
     */
    public function delete(int $contentId, int $fileId): array
    {
        return $this->client->delete("rest/content/{$contentId}/file/{$fileId}");
    }

    /**
     * Delete matching files from the specified content.
     */
    public function deleteMultiple(int $contentId, string $fileIds): array
    {
        return $this->client->delete("rest/content/{$contentId}/file?id={$fileIds}");
    }
}
