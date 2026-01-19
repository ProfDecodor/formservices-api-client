<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ContentAccessResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Find all accesses for a content.
     */
    public function findAll(int $contentId): array
    {
        return $this->client->get("rest/content/{$contentId}/access");
    }

    /**
     * Add a content access.
     */
    public function create(int $contentId, array $accessData): array
    {
        return $this->client->post("rest/content/{$contentId}/access", $accessData);
    }

    /**
     * Update an access.
     */
    public function update(int $contentId, int $partyId, array $accessData): array
    {
        return $this->client->put("rest/content/{$contentId}/access/{$partyId}", $accessData);
    }

    /**
     * Delete a content access.
     */
    public function delete(int $contentId, int $partyId): array
    {
        return $this->client->delete("rest/content/{$contentId}/access/{$partyId}");
    }

    /**
     * Find possible accesses.
     */
    public function findOptions(int $contentId): array
    {
        return $this->client->get("rest/content/{$contentId}/access/options");
    }
}
