<?php

namespace Jway\FormServicesApiClient\Tests\Unit;

use Jway\FormServicesApiClient\ClientFactory;
use Jway\FormServicesApiClient\FormServicesClient;
use Jway\FormServicesApiClient\Tests\TestCase;

class FormServicesClientTest extends TestCase
{
    protected FormServicesClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new FormServicesClient(
            'https://test.api.com',
            'test-login',
            'test-api-key'
        );
    }

    public function test_client_can_be_instantiated(): void
    {
        $this->assertInstanceOf(FormServicesClient::class, $this->client);
    }

    public function test_client_has_login(): void
    {
        $this->assertEquals('test-login', $this->client->getLogin());
    }

    public function test_client_has_base_url(): void
    {
        $this->assertEquals('https://test.api.com', $this->client->getBaseUrl());
    }

    public function test_facade_returns_factory(): void
    {
        $factory = \Jway\FormServicesApiClient\Facades\FormServicesClient::getFacadeRoot();

        $this->assertInstanceOf(ClientFactory::class, $factory);
    }

    public function test_can_get_default_client_via_facade(): void
    {
        $client = \Jway\FormServicesApiClient\Facades\FormServicesClient::client();

        $this->assertInstanceOf(FormServicesClient::class, $client);
    }

    public function test_can_get_named_client_via_facade(): void
    {
        $client = \Jway\FormServicesApiClient\Facades\FormServicesClient::client('main');

        $this->assertInstanceOf(FormServicesClient::class, $client);
    }
}