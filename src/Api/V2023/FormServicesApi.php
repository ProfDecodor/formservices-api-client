<?php

namespace Jway\FormServicesApiClient\Api\V2023;

use Jway\FormServicesApiClient\Api\Contracts\ApiClientInterface;
use Jway\FormServicesApiClient\Api\V2023\Resources\ApplicationResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\AttachmentResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\AuthenticationResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\ContentResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\DocumentResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\FileResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\FileCreationResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\ProjectResource;
use Jway\FormServicesApiClient\FormServicesClient;

class FormServicesApi implements ApiClientInterface
{
    protected FormServicesClient $client;
    protected string $version = '2023';

    public function __construct(FormServicesClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get the API version.
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Get the base HTTP client.
     */
    public function getHttpClient(): FormServicesClient
    {
        return $this->client;
    }

    /**
     * Access Application services.
     */
    public function applications(): ApplicationResource
    {
        return new ApplicationResource($this->client);
    }

    /**
     * Access Attachment services.
     */
    public function attachments(): AttachmentResource
    {
        return new AttachmentResource($this->client);
    }

    /**
     * Access Authentication services.
     */
    public function auth(): AuthenticationResource
    {
        return new AuthenticationResource($this->client);
    }

    /**
     * Access Document services.
     */
    public function documents(): DocumentResource
    {
        return new DocumentResource($this->client);
    }

    /**
     * Access File services.
     */
    public function files(): FileResource
    {
        return new FileResource($this->client);
    }

    /**
     * Access File creation services.
     */
    public function start(): FileCreationResource
    {
        return new FileCreationResource($this->client);
    }

    /**
     * Access Content services (Studio).
     */
    public function contents(): ContentResource
    {
        return new ContentResource($this->client);
    }

    /**
     * Access Project services (Studio).
     */
    public function projects(): ProjectResource
    {
        return new ProjectResource($this->client);
    }
}
