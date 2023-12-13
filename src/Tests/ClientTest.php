<?php

namespace Mapbox\Tests;

use BadMethodCallException;
use InvalidArgumentException;
use MapboxApi\Api;
use MapboxApi\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

/**
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
class ClientTest extends TestCase
{
    /**
     * @test ->getHttpClient()
     */
    public function testCreateWithoutHttpClient()
    {
        $client = new Client('test-token');

        $this->assertInstanceOf(ClientInterface::class, $client->getHttpClient());
    }

    /**
     * @test ->getHttpClient()
     */
    public function testCreateWithHttpClient()
    {
        $mockClientInterface = $this->getMockBuilder(ClientInterface::class)
            ->getMock();

        $client = Client::createWithHttpClient('test-token', $mockClientInterface);

        $this->assertInstanceOf(ClientInterface::class, $client->getHttpClient());
    }

    /**
     * @test ->__call()
     */
    public function testCallMagicMethodException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Undefined API instance: "doesNotExist"');
        
        $client = new Client('test-token');
        $client->doesNotExist();
    }

    /**
     * @test ->__call()
     */
    public function testCallMagicMethod()
    {
        $client = new Client('test-token');
        $api = $client->datasets();

        $this->assertInstanceOf(\MapboxApi\Api\Datasets::class, $api);
    }

    /**
     * @test ->api()
     */
    public function testApiDoesNotExist()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Undefined API instance: "doesNotExist"');

        $client = new Client('test-token');
        $client->api('doesNotExist');
    }

    /**
     * @test ->api()
     *
     * @dataProvider getApiClassesProvider
     */
    public function testApiInstance($apiName, $class)
    {
        $client = new Client('test-token');

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    public function getApiClassesProvider()
    {
        return [
            ['datasets', Api\Datasets::class],
        ];
    }
}