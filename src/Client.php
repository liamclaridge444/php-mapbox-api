<?php

namespace MapboxApi;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\QueryDefaultsPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
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