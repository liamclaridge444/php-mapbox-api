<?php

namespace MapboxApi\Tests\HttpClient;

use MapboxApi\HttpClient\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
class ResponseTest extends TestCase
{
    /**
     * @test ->getStatusCode()
     */
    public function testGetStatusCode()
    {
        $mockResponseInterface = $this->createMock(ResponseInterface::class);
        $mockResponseInterface->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        
        $response = new Response($mockResponseInterface);

        $statusCode = $response->getStatusCode();

        $this->assertEquals(200, $statusCode);
    }

    /**
     * @test ->getHeaders()
     */
    public function testGetHeaders()
    {
        $mockResponseInterface = $this->createMock(ResponseInterface::class);
        $mockResponseInterface->expects($this->once())
            ->method('getHeaders')
            ->willReturn(['Content-Type' => 'application/json']);
        
        $response = new Response($mockResponseInterface);

        $headers = $response->getHeaders();

        $this->assertEquals(['Content-Type' => 'application/json'], $headers);
    }

    /**
     * @test ->getContent()
     */
    public function testGetContentNotJson()
    {
        $mockStreamInterface = $this->createMock(StreamInterface::class);
        $mockStreamInterface->expects($this->once())
            ->method('__toString')
            ->willReturn('{"foo":"bar"}');

        $mockResult = $this->createMock(ResponseInterface::class);
        $mockResult->expects($this->once())
            ->method('getBody')
            ->willReturn($mockStreamInterface);
        $mockResult->expects($this->once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('foo');

        $response = new Response($mockResult);
        $this->assertEquals('{"foo":"bar"}', $response->getContent());
    }

    /**
     * @test ->getContent()
     */
    public function testGetContentJson()
    {
        $mockStreamInterface = $this->getMockBuilder(StreamInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockStreamInterface->expects($this->once())
            ->method('__toString')
            ->willReturn('{"foo":"bar"}');


        $mockResult = $this->createMock(ResponseInterface::class);
        $mockResult->expects($this->once())
            ->method('getBody')
            ->willReturn($mockStreamInterface);
        $mockResult->expects($this->once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/json');

        $response = new Response($mockResult);
        $this->assertEquals(['foo' => 'bar'], $response->getContent());
    }
}