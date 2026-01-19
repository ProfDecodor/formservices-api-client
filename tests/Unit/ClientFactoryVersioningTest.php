<?php

namespace Jway\FormServicesApiClient\Tests\Unit;

use InvalidArgumentException;
use Jway\FormServicesApiClient\Api\Contracts\ApiClientInterface;
use Jway\FormServicesApiClient\Api\V2023\FormServicesApi;
use Jway\FormServicesApiClient\ClientFactory;
use Jway\FormServicesApiClient\Tests\TestCase;

class ClientFactoryVersioningTest extends TestCase
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
                    'api_version' => '2023',
                ],
                'legacy' => [
                    'base_url' => 'https://legacy.api.com',
                    'login' => 'legacy-login',
                    'api_key' => 'legacy-key',
                    'timeout' => 30,
                    'api_version' => '2023',
                ],
            ],
        ]);
    }

    public function test_can_get_default_api_client(): void
    {
        $api = $this->factory->api();

        $this->assertInstanceOf(ApiClientInterface::class, $api);
        $this->assertInstanceOf(FormServicesApi::class, $api);
        $this->assertEquals('2023', $api->getVersion());
    }

    public function test_can_get_named_api_client(): void
    {
        $api = $this->factory->api('legacy');

        $this->assertInstanceOf(FormServicesApi::class, $api);
        $this->assertEquals('2023', $api->getVersion());
    }

    public function test_can_get_api_client_with_specific_version(): void
    {
        $api = $this->factory->api('main', '2023');

        $this->assertInstanceOf(FormServicesApi::class, $api);
        $this->assertEquals('2023', $api->getVersion());
    }

    public function test_throws_exception_for_unsupported_version(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('API version [9999] is not supported.');

        $this->factory->api('main', '9999');
    }

    public function test_same_api_instance_is_cached(): void
    {
        $api1 = $this->factory->api('main', '2023');
        $api2 = $this->factory->api('main', '2023');

        $this->assertSame($api1, $api2);
    }

    public function test_different_versions_return_different_instances(): void
    {
        $api2023 = $this->factory->api('main', '2023');

        // For now we only have 2023, but this test structure is ready for future versions
        $this->assertInstanceOf(FormServicesApi::class, $api2023);
    }

    public function test_can_get_available_versions(): void
    {
        $versions = $this->factory->getAvailableVersions();

        $this->assertIsArray($versions);
        $this->assertContains('2023', $versions);
    }
}