<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ContentTranslationResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Add a content translation.
     */
    public function create(int $contentId, array $translationData): array
    {
        return $this->client->post("rest/content/{$contentId}/translation", $translationData);
    }

    /**
     * Update one or more content translations.
     */
    public function updateBatch(int $contentId, array $translations): array
    {
        return $this->client->put("rest/content/{$contentId}/translation", $translations);
    }

    /**
     * Update a content translation.
     */
    public function update(int $contentId, string $language, array $translationData): array
    {
        return $this->client->put("rest/content/{$contentId}/translation/{$language}", $translationData);
    }

    /**
     * Delete a content translation.
     */
    public function delete(int $contentId, string $language): array
    {
        return $this->client->delete("rest/content/{$contentId}/translation/{$language}");
    }
}