<?php

namespace MapboxApi\Api;

use Exception;
use MapboxApi\Client;
use MapboxApi\HttpClient\Response;

/**
 * Base class for all API classes.
 * 
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
abstract class AbstractApi
{
    /**
     * The client instance.
     * 
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Get ther username from the access token.
     * 
     * @throws Exception
     * 
     * @return string
     */
    protected function username(): string
    {
        $accessToken = $this->client->getAccessToken();

        $parts = explode('.', $accessToken);

        if (count($parts) !== 3) {
            throw new Exception('Invalid token');
        }

        $rawPayload = $parts[1];

        if (empty($rawPayload)) {
            throw new Exception('Invalid token');
        }

        $parsedPayload = json_decode(base64_decode($rawPayload), true);

        return $parsedPayload['u'];
    }

    /**
     * Send a GET request with query parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     GET parameters.
     * @param array  $requestHeaders Request Headers.
     *
     * @return Response
     */
    public function get(string $endpoint, array $parameters = [], array $requestHeaders = []): Response
    {
        if (count($parameters) > 0) {
            $endpoint .= '?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        $result = $this->client->getHttpClient()->get($endpoint, $requestHeaders);

        return new Response($result);
    }

    /**
     * Send a POST request with JSON-encoded body.
     *
     * @param string $path           Request path.
     * @param array  $body           POST body to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return Response
     */
    public function post(string $endpoint, array $body, array $requestHeaders = []): Response
    {
        $result = $this->client->getHttpClient()->post($endpoint, $requestHeaders, json_encode($body));

        return new Response($result);
    }

    /**
     * Send a PATCH request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     PATCH parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return Response
     */
    public function patch(string $endpoint, array $parameters, array $requestHeaders = []): Response
    {
        $result = $this->client->getHttpClient()->patch($endpoint, $requestHeaders, json_encode($parameters));

        return new Response($result);
    }

    /**
     * Send a DELETE request with JSON-encoded parameters.
     *
     * @param string $path           Request path.
     * @param array  $parameters     POST parameters to be JSON encoded.
     * @param array  $requestHeaders Request headers.
     *
     * @return Response
     */
    public function delete(string $endpoint, array $parameters = [], array $requestHeaders = []): Response
    {
        $result = $this->client->getHttpClient()->delete($endpoint, $requestHeaders, json_encode($parameters));

        return new Response($result);
    }
}