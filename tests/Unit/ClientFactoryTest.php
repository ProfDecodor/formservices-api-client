<?php

namespace Jway\FormServicesApiClient\Tests\Unit;

use InvalidArgumentException;
use Jway\FormServicesApiClient\ClientFactory;
use Jway\FormServicesApiClient\FormServicesClient;
use Jway\FormServicesApiClient\Tests\TestCase;

class ClientFactoryTest extends TestCase
{
    protected ClientFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new ClientFactory([
            'default' => 'main',
            'clients' => [
                'main' => [
                    'base_url' => 'https://main.api.com',
                    'login' => 'main-login',
                    'api_key' => 'main-key',
                    'timeout' => 30,
                ],
                'secondary' => [
                    'base_url' => 'https://secondary.api.com',
                    'login' => 'secondary-login',
                    'api_key' => 'secondary-key',
                    'timeout' => 60,
                ],
            ],
        ]);
    }

    public function test_factory_can_be_instantiated(): void
    {
        $this->assertInstanceOf(ClientFactory::class, $this->factory);
    }

    public function test_can_get_default_client(): void
    {
        $client = $this->factory->client();

        $this->assertInstanceOf(FormServicesClient::class, $client);
        $this->assertEquals('https://main.api.com', $client->getBaseUrl());
        $this->assertEquals('main-login', $client->getLogin());
    }

    public function test_can_get_named_client(): void
    {
        $client = $this->factory->client('secondary');

        $this->assertInstanceOf(FormServicesClient::class, $client);
        $this->assertEquals('https://secondary.api.com', $client->getBaseUrl());
        $this->assertEquals('secondary-login', $client->getLogin());
    }

    public function test_same_client_instance_is_returned(): void
    {
        $client1 = $this->factory->client('main');
        $client2 = $this->factory->client('main');

        $this->assertSame($client1, $client2);
    }

    public function test_throws_exception_for_non_existent_client(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Client [non-existent] is not configured.');

        $this->factory->client('non-existent');
    }

    public function test_can_check_if_client_exists(): void
    {
        $this->assertTrue($this->factory->hasClient('main'));
        $this->assertTrue($this->factory->hasClient('secondary'));
        $this->assertFalse($this->factory->hasClient('non-existent'));
    }

    public function test_can_get_available_clients(): void
    {
        $clients = $this->factory->getAvailableClients();

        $this->assertIsArray($clients);
        $this->assertContains('main', $clients);
        $this->assertContains('secondary', $clients);
        $this->assertCount(2, $clients);
    }
}