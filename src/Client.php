<?php

namespace MapboxApi;

use BadMethodCallException;
use Error;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\QueryDefaultsPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use MapboxApi\Api\AbstractApi;
use MapboxApi\HttpClient\Builder;
use Psr\Http\Client\ClientInterface;

/**
 * PHP Mapbox client.
 * 
 * @method Api\Datasets datasets()
 * 
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
class Client
{
    /**
     * The token used to access the API.
     * 
     * @var string
     */
    private $accessToken;

    /**
     * The HTTP client builder, used to build the API client.
     * 
     * @var Builder
     */
    private $httpClientBuilder;

    /**
     * @param string       $accessToken
     * @param Builder|null $httpClientBuilder
     */
    public function __construct(string $accessToken, Builder $httpClientBuilder = null)
    {
        $this->accessToken = $accessToken;
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? (new Builder());

        $builder->addPlugin(new Plugin\AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri('https://api.mapbox.com')));
        $builder->addPlugin(new Plugin\ContentTypePlugin());
        $builder->addPlugin(new QueryDefaultsPlugin([
            'access_token' => $this->accessToken
        ]));
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * Create a MapboxApi\Client using an access token and HTTP client.
     *
     * @param string          $accessToken
     * @param ClientInterface $httpClient
     *
     * @return Client
     */
    public static function createWithHttpClient(string $accessToken, ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($accessToken, $builder);
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return AbstractApi
     */
    public function __call($name, $arguments): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException($e->getMessage());
        }
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractApi
     */
    public function api($name): AbstractApi
    {
        $class = $this->resolveClassPath($name);
    
        try {
            return new $class($this);
        } catch (Error $e) {
            throw new InvalidArgumentException(sprintf('Undefined API instance: "%s"', $name));
        }
    }

    /**
     * Get the resource path.
     *
     * @param $resource
     * 
     * @return string
     */
    protected function resolveClassPath($resource)
    {
        return 'MapboxApi\\Api\\' . ucfirst($resource);
    }

    /**
     * @return HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * @return Builder
     */
    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}