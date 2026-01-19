<?php

namespace Jway\FormServicesApiClient\Api\V2023\Resources;

use Jway\FormServicesApiClient\FormServicesClient;

class FileCreationResource
{
    protected FormServicesClient $client;

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * List applications available to user.
     */
    public function findAll(?string $lang = null, ?string $group = null): array
    {
        return $this->client->get('rest/start', [
            'lang' => $lang,
            'group' => $group,
        ]);
    }

    /**
     * Start a new file.
     */
    public function start(
        string $applicationName,
        ?string $name = null,
        ?string $lang = null
    ): array {
        return $this->client->post("rest/start/{$applicationName}", [
            'name' => $name,
            'lang' => $lang,
        ]);
    }

    /**
     * Start a new file in selected group.
     */
    public function startInGroup(
        string $applicationName,
        string $groupName,
        ?string $name = null,
        ?string $lang = null
    ): array {
        return $this->client->post("rest/start/{$applicationName}/ingroup/{$groupName}", [
            'name' => $name,
            'lang' => $lang,
        ]);
    }
}