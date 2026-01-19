<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class DocumentResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Find a specific document.
     */
    public function find(string $documentUuid, ?string $token = null, bool $inline = false): array
    {
        return $this->client->get("rest/document/{$documentUuid}", [
            'token' => $token,
            'inline' => $inline,
        ]);
    }

    /**
     * Find all documents with filters.
     */
    public function findAll(array $filters = []): array
    {
        return $this->client->get('rest/document', $filters);
    }
}