<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class ProjectResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Deploy the WAR file built from this project.
     */
    public function deploy(int $contentId): array
    {
        return $this->client->post("rest/project/{$contentId}/deploy", []);
    }

    /**
     * Download the WAR file built from this project.
     */
    public function findBuild(int $contentId): array
    {
        return $this->client->get("rest/project/{$contentId}/build");
    }

    /**
     * Update a project build.
     */
    public function updateBuild(int $contentId, array $buildData): array
    {
        return $this->client->put("rest/project/{$contentId}/build", $buildData);
    }

    /**
     * Prepare a project build.
     */
    public function prepareForBuild(int $contentId): array
    {
        return $this->client->post("rest/project/{$contentId}/prepare", []);
    }

    /**
     * Redirect to the deployed form.
     */
    public function test(int $contentId): array
    {
        return $this->client->get("rest/project/{$contentId}/test");
    }
}
