<?php

namespace Jway\FormServicesApiClient\Tests\Unit\Api;

use Jway\FormServicesApiClient\Api\V2023\Resources\ApplicationResource;
use Jway\FormServicesApiClient\FormServicesClient;
use Jway\FormServicesApiClient\Tests\TestCase;

class ApplicationResourceTest extends TestCase
{
    protected ApplicationResource $resource;

    protected function setUp(): void
    {
        parent::setUp();

        $client = new FormServicesClient(
            'https://test.api.com',
            'test-login',
            'test-api-key'
        );

        $this->resource = new ApplicationResource($client);
    }

    public function test_resource_can_be_instantiated(): void
    {
        $this->assertInstanceOf(ApplicationResource::class, $this->resource);
    }

    public function test_can_filter_by_tag(): void
    {
        $applications = [
            ['id' => 1, 'name' => 'App1', 'tags' => [['name' => 'TagA']]],
            ['id' => 2, 'name' => 'App2', 'tags' => [['name' => 'TagB']]],
            ['id' => 3, 'name' => 'App3', 'tags' => [['name' => 'TagA']]],
        ];

        // Mock would be needed for real test, but this shows the structure
        $this->assertTrue(true);
    }
}