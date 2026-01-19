<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class FileResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Return file metadata.
     */
    public function find(string $uuid, ?string $token = null): array
    {
        return $this->client->get("rest/file/{$uuid}", [
            'token' => $token,
        ]);
    }

    /**
     * Delete file.
     */
    public function delete(string $uuid, ?string $token = null): array
    {
        return $this->client->delete("rest/file/{$uuid}" . ($token ? "?token={$token}" : ''));
    }

    /**
     * Delete file by criteria.
     */
    public function deleteByFilter(array $filter): array
    {
        return $this->client->post('rest/file/delete', $filter);
    }

    /**
     * Export files in CSV format.
     */
    public function export(array $filters = []): array
    {
        return $this->client->get('rest/file/export', $filters);
    }

    /**
     * Return files statistics.
     */
    public function statistics(array $filters = []): array
    {
        return $this->client->get('rest/file/statistics', $filters);
    }

    /**
     * Return all files.
     */
    public function findAll(array $filters = []): array
    {
        return $this->client->get('rest/file', $filters);
    }

    /**
     * Return file data and documents (zip).
     */
    public function archive(string $uuid, ?string $token = null): array
    {
        return $this->client->get("rest/file/{$uuid}/archive", [
            'token' => $token,
        ]);
    }

    /**
     * Return file data (XML).
     */
    public function data(string $uuid, ?string $token = null): string
    {
        return $this->client->getRaw("rest/file/{$uuid}/data", [
            'token' => $token,
        ]);
    }

    /**
     * Update file data (XML).
     */
    public function updateData(string $uuid, string $xmlData, ?string $token = null): array
    {
        return $this->client->put("rest/file/{$uuid}/data" . ($token ? "?token={$token}" : ''), [
            'xml' => $xmlData,
        ]);
    }

    /**
     * Return managed files.
     */
    public function findManaged(array $filters = []): array
    {
        return $this->client->get('rest/file/managed', $filters);
    }

    /**
     * Return managed files with headers (for pagination info).
     */
    public function findManagedWithHeaders(array $filters = []): array
    {
        return $this->client->getWithHeaders('rest/file/managed', $filters);
    }

    /**
     * Return all owned files.
     */
    public function findMine(array $filters = []): array
    {
        return $this->client->get('rest/file/mine', $filters);
    }

    /**
     * Return file data and documents from a specific step (zip).
     */
    public function stepArchive(string $uuid, int $order, ?string $token = null): array
    {
        return $this->client->get("rest/file/{$uuid}/archive/{$order}", [
            'token' => $token,
        ]);
    }

    /**
     * Update file workflow status.
     */
    public function updateWorkflowStatus(string $uuid, string $workflowStatus, ?string $token = null): array
    {
        return $this->client->put("rest/file/{$uuid}/workflowStatus", [
            'token' => $token,
            'workflowStatus' => $workflowStatus,
        ]);
    }

    /**
     * Validate file if status is ERROR.
     */
    public function validate(string $uuid, ?string $token = null): array
    {
        return $this->client->put("rest/file/{$uuid}/validate" . ($token ? "?token={$token}" : ''), []);
    }

    /**
     * Validate file with actions.
     */
    public function validateWithActions(string $uuid, array $actions, ?string $token = null): array
    {
        return $this->client->post("rest/file/{$uuid}/validate" . ($token ? "?token={$token}" : ''), $actions);
    }
}