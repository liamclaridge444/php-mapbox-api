<?php

namespace MapboxApi\HttpClient;

use Psr\Http\Message\ResponseInterface;

/**
 * Wrapper for PSR-7 (ResponseInterface).
 * 
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
final class Response
{
    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    /**
     * @return array|string
     */
    public function getContent()
    {
        $body = $this->response->getBody()->__toString();
        if ($this->response->getHeaderLine('Content-Type') === 'application/json') {
            $content = json_decode($body, true);
            if (JSON_ERROR_NONE === json_last_error()) {
                return $content;
            }
        }

        return $body;
    }
}