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
     * Find all Studio projects.
     *
     * Projects are Studio contents of type PROJECT. This method is a convenience
     * wrapper around contents()->findAll('PROJECT'). Both are equivalent; prefer
     * this one when your intent is specifically about projects — it is more
     * self-documenting and keeps project-related code together.
     *
     * The returned array items include:
     *   - id         (int)    : legacy record ID
     *   - contentId  (int)    : ID used for all build/deploy operations
     *   - name       (string) : project name
     *   - type       (string) : always 'PROJECT'
     *   - status     (string) : e.g. 'ACTIVE', 'ARCHIVED'
     *   - version    (string) : semantic version string
     *
     * @param  string|null  $name   Partial name filter.
     * @param  string|null  $query  Additional free-text query filter.
     * @return array<int, array<string, mixed>>
     */
    public function findAll(?string $name = null, ?string $query = null): array
    {
        return $this->client->get('rest/content', [
            'type'  => 'PROJECT',
            'name'  => $name,
            'query' => $query,
        ]);
    }

    /**
     * Retrieve the current build information for a project.
     *
     * Use the contentId field from findAll() results, not the legacy id field.
     *
     * @param  int  $contentId  The project's contentId.
     * @return array<string, mixed>
     */
    public function findBuild(int $contentId): array
    {
        return $this->client->get("rest/project/{$contentId}/build");
    }

    /**
     * Update build metadata for a project.
     *
     * @param  int                   $contentId  The project's contentId.
     * @param  array<string, mixed>  $buildData  Fields to update on the build record.
     * @return array<string, mixed>
     */
    public function updateBuild(int $contentId, array $buildData): array
    {
        return $this->client->put("rest/project/{$contentId}/build", $buildData);
    }

    /**
     * Prepare a project for a new build.
     *
     * Writes the project content to the server filesystem so a WAR build
     * can be triggered. Must be called before deploy().
     *
     * @param  int  $contentId  The project's contentId.
     * @return array<string, mixed>
     */
    public function prepareForBuild(int $contentId): array
    {
        return $this->client->post("rest/project/{$contentId}/prepare", []);
    }

    /**
     * Deploy the WAR file built from this project to the application server.
     *
     * Typical sequence: prepareForBuild() → deploy() → test().
     *
     * @param  int  $contentId  The project's contentId.
     * @return array<string, mixed>
     */
    public function deploy(int $contentId): array
    {
        return $this->client->post("rest/project/{$contentId}/deploy", []);
    }

    /**
     * Test the deployed project by redirecting to the live form URL.
     *
     * Returns a redirect URL. The response may contain a 'url' or 'redirect' key
     * pointing to the deployed form entry point.
     *
     * @param  int  $contentId  The project's contentId.
     * @return array<string, mixed>
     */
    public function test(int $contentId): array
    {
        return $this->client->get("rest/project/{$contentId}/test");
    }
}
