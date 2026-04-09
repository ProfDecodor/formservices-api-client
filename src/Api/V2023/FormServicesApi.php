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
     * Access Studio content management services.
     *
     * Covers all content types: PROJECT, MODULE, FORM, WORKFLOW, LIBRARY, etc.
     * Also exposes sub-resources: accesses(), files(), repositories(),
     * translations(), subContents().
     *
     * To list projects specifically, consider using projects()->findAll()
     * which is more self-documenting than contents()->findAll('PROJECT').
     */
    public function contents(): ContentResource
    {
        return new ContentResource($this->client);
    }

    /**
     * Access Studio project build and deployment services.
     *
     * Projects are Studio contents of type PROJECT. This resource covers
     * build lifecycle operations: findAll, findBuild, prepareForBuild,
     * deploy, updateBuild, test.
     *
     * Typical deploy sequence:
     *   $api->projects()->prepareForBuild($contentId);
     *   $api->projects()->deploy($contentId);
     *   $api->projects()->test($contentId);
     *
     * Note: all methods require the contentId from the project record,
     * not the legacy id field. Use findAll() to retrieve contentId values.
     */
    public function projects(): ProjectResource
    {
        return new ProjectResource($this->client);
    }
}
