<?php

namespace Jway\FormServicesApiClient\Api\Contracts;

interface ApiClientInterface
{
    /**
     * Get the API version.
     */
    public function getVersion(): string;

    /**
     * Get the base HTTP client.
     */
    public function getHttpClient(): \Jway\FormServicesApiClient\FormServicesClient;
}
