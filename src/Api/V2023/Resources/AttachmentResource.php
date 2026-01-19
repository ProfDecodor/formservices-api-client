<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class AttachmentResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get file attachments.
     */
    public function findByFile(string $fileUuid, ?string $token = null): array
    {
        return $this->client->get("rest/document/ds/{$fileUuid}/attachment", [
            'token' => $token,
        ]);
    }

    /**
     * Create attachment.
     */
    public function create(string $fileUuid, array $data, ?string $token = null): array
    {
        // This is a multipart/form-data request
        // For now, we'll keep it simple - users can use the base client for complex uploads
        return $this->client->post("rest/document/ds/{$fileUuid}/attachment", array_merge(
            $data,
            ['token' => $token]
        ));
    }

    /**
     * Delete attachment.
     */
    public function delete(string $fileUuid, string $documentUuid, ?string $token = null): array
    {
        return $this->client->delete("rest/document/ds/{$fileUuid}/attachment/{$documentUuid}" .
            ($token ? "?token={$token}" : ''));
    }

    /**
     * Get a part of a document.
     */
    public function findFile(
        string $fileUuid,
        string $documentUuid,
        int $order,
        ?string $token = null,
        bool $inline = false
    ): array {
        return $this->client->get(
            "rest/document/ds/{$fileUuid}/attachment/{$documentUuid}/file/{$order}",
            [
                'token' => $token,
                'inline' => $inline,
            ]
        );
    }

    /**
     * Delete attachment with order.
     */
    public function deleteFile(
        string $fileUuid,
        string $documentUuid,
        int $order,
        ?string $token = null
    ): array {
        return $this->client->delete(
            "rest/document/ds/{$fileUuid}/attachment/{$documentUuid}/file/{$order}" .
            ($token ? "?token={$token}" : '')
        );
    }

    /**
     * Get complete document.
     */
    public function findFiles(
        string $fileUuid,
        string $documentUuid,
        ?string $token = null,
        bool $inline = false
    ): array {
        return $this->client->get(
            "rest/document/ds/{$fileUuid}/attachment/{$documentUuid}/file",
            [
                'token' => $token,
                'inline' => $inline,
            ]
        );
    }
}
