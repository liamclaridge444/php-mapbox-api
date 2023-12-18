<?php

namespace MapboxApi\Tests\Api;

use Exception;
use Http\Client\Common\HttpMethodsClientInterface;
use MapboxApi\Api\AbstractApi;
use MapboxApi\Client;
use MapboxApi\HttpClient\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * The token used in these tests was taken from the Mapbox API
 * docs: https://docs.mapbox.com/api/accounts/tokens/
 * 
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
class AbstractApiTest extends TestCase
{
    /**
     * @test ->username()
     */
    public function testUsernameInvalidTokenParts()
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn('pk.eyJ1Ijoic2NvdGhpcyIsImEiOiJjaWp1Y2ltYmUwMDBicmJrdDQ4ZDBkaGN4In0');

        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $method = (new \ReflectionClass($mockApiClass))->getMethod('username');
        $method->setAccessible(true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid token');

        $result = $method->invoke($mockApiClass);
    }

    /**
     * @test ->username()
     */
    public function testUsernameInvalidTokenPayload()
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn('pk..sbihZCZJ56-fsFNKHXF8YQ');

        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $method = (new \ReflectionClass($mockApiClass))->getMethod('username');
        $method->setAccessible(true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid token');

        $result = $method->invoke($mockApiClass);
    }

    /**
     * @test ->username()
     */
    public function testUsernameSucceeds()
    {
        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn('pk.eyJ1Ijoic2NvdGhpcyIsImEiOiJjaWp1Y2ltYmUwMDBicmJrdDQ4ZDBkaGN4In0.sbihZCZJ56-fsFNKHXF8YQ');

        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $method = (new \ReflectionClass($mockApiClass))->getMethod('username');
        $method->setAccessible(true);

        $result = $method->invoke($mockApiClass);

        $this->assertEquals('scothis', $result);
    }

    /**
     * @test ->get()
     */
    public function testGetWithSingleParameter()
    {
        $responseInterface = $this->createMock(ResponseInterface::class);

        $mockHttpClientInterface = $this->createMock(HttpMethodsClientInterface::class);
        $mockHttpClientInterface->expects($this->once())
            ->method('get')
            ->with('endpoint?limit=300', [])
            ->willReturn($responseInterface);

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($mockHttpClientInterface);

        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $response = $mockApiClass->get('endpoint', ['limit' => 300]);

        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @test ->get()
     */
    public function testGetWithMultipleParameters()
    {
        $responseInterface = $this->createMock(ResponseInterface::class);

        $mockHttpClientInterface = $this->createMock(HttpMethodsClientInterface::class);
        $mockHttpClientInterface->expects($this->once())
            ->method('get')
            ->with('endpoint?start=foo&limit=300', [])
            ->willReturn($responseInterface);

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($mockHttpClientInterface);
        
        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $response = $mockApiClass->get('endpoint', ['start' => 'foo', 'limit' => 300]);

        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @test ->get()
     */
    public function testGetWithoutParameters()
    {
        $responseInterface = $this->createMock(ResponseInterface::class);

        $mockHttpClientInterface = $this->createMock(HttpMethodsClientInterface::class);
        $mockHttpClientInterface->expects($this->once())
            ->method('get')
            ->with('endpoint', [])
            ->willReturn($responseInterface);

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($mockHttpClientInterface);
        
        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $response = $mockApiClass->get('endpoint');

        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @test ->post()
     */
    public function testPost()
    {
        $responseInterface = $this->createMock(ResponseInterface::class);

        $mockHttpClientInterface = $this->createMock(HttpMethodsClientInterface::class);
        $mockHttpClientInterface->expects($this->once())
            ->method('post')
            ->with('endpoint', [], '{"foo":"bar","baz":"foo-bar"}')
            ->willReturn($responseInterface);

        $mockClient = $this->createMock(Client::class);
        $mockClient->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($mockHttpClientInterface);
        
        $mockApiClass = $this->getMockForAbstractClass(AbstractApi::class, [$mockClient]);

        $response = $mockApiClass->post('endpoint', ['foo' => 'bar', 'baz' => 'foo-bar']);

        $this->assertInstanceOf(Response::class, $response);
    }
}