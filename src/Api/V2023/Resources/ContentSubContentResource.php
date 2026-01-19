<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ContentSubContentResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Add a sub-content.
     */
    public function create(int $contentId, int $subContentId, ?int $order = null): array
    {
        return $this->client->post("rest/content/{$contentId}/subcontent/{$subContentId}", [
            'order' => $order,
        ]);
    }

    /**
     * Update a sub-content order.
     */
    public function update(int $contentId, int $subContentId, int $order): array
    {
        return $this->client->put("rest/content/{$contentId}/subcontent/{$subContentId}", [
            'order' => $order,
        ]);
    }

    /**
     * Remove a sub-content.
     */
    public function delete(int $contentId, int $subContentId): array
    {
        return $this->client->delete("rest/content/{$contentId}/subcontent/{$subContentId}");
    }
}
