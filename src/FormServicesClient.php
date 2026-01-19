<?php

namespace Jway\FormServicesApiClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class FormServicesClient
{
    protected Client $client;
    protected string $baseUrl;
    protected string $login;
    protected string $apiKey;
    protected int $timeout;
    protected bool $verifySsl;

    public function __construct(
        string $baseUrl,
        string $login = '',
        string $apiKey = '',
        int $timeout = 30,
        bool $verifySsl = true
    ) {
        $this->baseUrl = $baseUrl;
        $this->login = $login;
        $this->apiKey = $apiKey;
        $this->timeout = $timeout;
        $this->verifySsl = $verifySsl;

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $clientConfig = [
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => $headers,
            'verify' => $this->verifySsl,
        ];

        // Add Basic Auth if login and API key are provided
        if (!empty($this->login) && !empty($this->apiKey)) {
            $clientConfig['auth'] = [$this->login, $this->apiKey];
        }

        $this->client = new Client($clientConfig);
    }

    /**
     * Get the login associated with this client.
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Get the base URL of this client.
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Send a GET request to the API.
     */
    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = $this->client->get($endpoint, [
                'query' => $params,
            ]);

            $content = $response->getBody()->getContents();
            $decoded = json_decode($content, true);

            // Return empty array if decode failed or returned null
            return $decoded ?? [];
        } catch (GuzzleException $e) {
            Log::error('FormServices API GET error', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Send a GET request to the API and return both body and headers.
     */
    public function getWithHeaders(string $endpoint, array $params = []): array
    {
        try {
            $response = $this->client->get($endpoint, [
                'query' => $params,
            ]);

            return [
                'body' => json_decode($response->getBody()->getContents(), true),
                'headers' => $response->getHeaders(),
                'statusCode' => $response->getStatusCode(),
            ];
        } catch (GuzzleException $e) {
            Log::error('FormServices API GET error', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Send a GET request to the API and return raw content (for XML, binary, etc).
     */
    public function getRaw(string $endpoint, array $params = []): string
    {
        try {
            $response = $this->client->get($endpoint, [
                'query' => $params,
            ]);

            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            Log::error('FormServices API GET error', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Send a POST request to the API.
     */
    public function post(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('FormServices API POST error', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Send a PUT request to the API.
     */
    public function put(string $endpoint, array $data = []): array
    {
        try {
            $response = $this->client->put($endpoint, [
                'json' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('FormServices API PUT error', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Send a DELETE request to the API.
     */
    public function delete(string $endpoint): array
    {
        try {
            $response = $this->client->delete($endpoint);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('FormServices API DELETE error', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
