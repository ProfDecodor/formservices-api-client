<?php

namespace Jway\FormServicesApiClient\Tests\Unit\Api;

use Jway\FormServicesApiClient\Api\V2023\FormServicesApi;
use Jway\FormServicesApiClient\Api\V2023\Resources\ApplicationResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\AttachmentResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\AuthenticationResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\ContentResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\DocumentResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\FileResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\FileCreationResource;
use Jway\FormServicesApiClient\Api\V2023\Resources\ProjectResource;
use Jway\FormServicesApiClient\FormServicesClient;
use Jway\FormServicesApiClient\Tests\TestCase;

class FormServicesApiTest extends TestCase
{
    protected FormServicesApi $api;

    protected function setUp(): void
    {
        parent::setUp();

        $client = new FormServicesClient(
            'https://test.api.com',
            'test-login',
            'test-api-key'
        );

        $this->api = new FormServicesApi($client);
    }

    public function test_api_has_correct_version(): void
    {
        $this->assertEquals('2023', $this->api->getVersion());
    }

    public function test_api_returns_http_client(): void
    {
        $this->assertInstanceOf(FormServicesClient::class, $this->api->getHttpClient());
    }

    public function test_api_provides_applications_resource(): void
    {
        $this->assertInstanceOf(ApplicationResource::class, $this->api->applications());
    }

    public function test_api_provides_attachments_resource(): void
    {
        $this->assertInstanceOf(AttachmentResource::class, $this->api->attachments());
    }

    public function test_api_provides_auth_resource(): void
    {
        $this->assertInstanceOf(AuthenticationResource::class, $this->api->auth());
    }

    public function test_api_provides_documents_resource(): void
    {
        $this->assertInstanceOf(DocumentResource::class, $this->api->documents());
    }

    public function test_api_provides_files_resource(): void
    {
        $this->assertInstanceOf(FileResource::class, $this->api->files());
    }

    public function test_api_provides_start_resource(): void
    {
        $this->assertInstanceOf(FileCreationResource::class, $this->api->start());
    }

    public function test_api_provides_contents_resource(): void
    {
        $this->assertInstanceOf(ContentResource::class, $this->api->contents());
    }

    public function test_api_provides_projects_resource(): void
    {
        $this->assertInstanceOf(ProjectResource::class, $this->api->projects());
    }
}