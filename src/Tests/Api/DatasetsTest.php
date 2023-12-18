<?php

namespace MapboxApi\Tests\Api;

use MapboxApi\Api\Datasets;
use MapboxApi\Client;
use MapboxApi\HttpClient\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
class DatasetsTest extends TestCase
{
    /**
     * @test ->list()
     */
    public function testListNoParameters()
    {
        $mockStreamInterface = $this->createMock(StreamInterface::class);
        $mockStreamInterface->expects($this->once())
            ->method('__toString')
            ->willReturn($this->mockListResponseData());

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getHeaders')
            ->willReturn(['Content-Type' => ['application/json']]);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockStreamInterface);

        $response = new Response($mockResponse);

        $endpoint = sprintf('/%s/%s/%s', Datasets::API_NAME, Datasets::API_VERSION, 'scothis');
        $accessToken = 'pk.eyJ1Ijoic2NvdGhpcyIsImEiOiJjaWp1Y2ltYmUwMDBicmJrdDQ4ZDBkaGN4In0.sbihZCZJ56-fsFNKHXF8YQ';

        $mockClient = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$accessToken])
            ->getMock();
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn($accessToken);

        $mockDatasets = $this->getMockBuilder(Datasets::class)
            ->setConstructorArgs([$mockClient])
            ->onlyMethods(['get'])
            ->getMock();

        $mockDatasets->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($response);

        $apiResponse = $mockDatasets->list();

        $this->assertSame(200, $apiResponse->getStatusCode());
        $this->assertSame(['Content-Type' => ['application/json']], $apiResponse->getHeaders());
        $this->assertSame($this->mockListResponseData(), $apiResponse->getContent());
    }

    /**
     * @test ->list()
     */
    public function testListWithParameters()
    {
        $mockStreamInterface = $this->createMock(StreamInterface::class);
        $mockStreamInterface->expects($this->once())
            ->method('__toString')
            ->willReturn($this->mockListResponseData());

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getHeaders')
            ->willReturn(['Content-Type' => ['application/json']]);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockStreamInterface);

        $response = new Response($mockResponse);

        $endpoint = sprintf('/%s/%s/%s', Datasets::API_NAME, Datasets::API_VERSION, 'scothis');
        $accessToken = 'pk.eyJ1Ijoic2NvdGhpcyIsImEiOiJjaWp1Y2ltYmUwMDBicmJrdDQ4ZDBkaGN4In0.sbihZCZJ56-fsFNKHXF8YQ';

        $mockClient = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$accessToken])
            ->getMock();
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn($accessToken);

        $mockDatasets = $this->getMockBuilder(Datasets::class)
            ->setConstructorArgs([$mockClient])
            ->onlyMethods(['get'])
            ->getMock();

        $mockDatasets->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($response);

        $apiResponse = $mockDatasets->list(['foo' => 'bar']);

        $this->assertSame(200, $apiResponse->getStatusCode());
        $this->assertSame(['Content-Type' => ['application/json']], $apiResponse->getHeaders());
        $this->assertSame($this->mockListResponseData(), $apiResponse->getContent());
    }

    /**
     * @test ->retrieve()
     */
    public function testRetrieve()
    {
        $mockStreamInterface = $this->createMock(StreamInterface::class);
        $mockStreamInterface->expects($this->once())
            ->method('__toString')
            ->willReturn($this->mockRetrieveResponseData());

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getHeaders')
            ->willReturn(['Content-Type' => ['application/json']]);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockStreamInterface);

        $response = new Response($mockResponse);

        $datasetId = 'foo';
        $username = 'scothis';
        $endpoint = sprintf('/%s/%s/%s/%s', Datasets::API_NAME, Datasets::API_VERSION, $username, $datasetId);
        $accessToken = 'pk.eyJ1Ijoic2NvdGhpcyIsImEiOiJjaWp1Y2ltYmUwMDBicmJrdDQ4ZDBkaGN4In0.sbihZCZJ56-fsFNKHXF8YQ';

        $mockClient = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$accessToken])
            ->getMock();
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn($accessToken);

        $mockDatasets = $this->getMockBuilder(Datasets::class)
            ->setConstructorArgs([$mockClient])
            ->onlyMethods(['get'])
            ->getMock();

        $mockDatasets->expects($this->once())
            ->method('get')
            ->with($endpoint)
            ->willReturn($response);

        $apiResponse = $mockDatasets->retrieve('foo');

        $this->assertSame(200, $apiResponse->getStatusCode());
        $this->assertSame(['Content-Type' => ['application/json']], $apiResponse->getHeaders());
        $this->assertSame($this->mockRetrieveResponseData(), $apiResponse->getContent());
    }

    /**
     * @test ->create()
     */
    public function testCreate()
    {
        $mockStreamInterface = $this->createMock(StreamInterface::class);
        $mockStreamInterface->expects($this->once())
            ->method('__toString')
            ->willReturn($this->mockCreateResponseData());

        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);
        $mockResponse->expects($this->once())
            ->method('getHeaders')
            ->willReturn(['Content-Type' => ['application/json']]);
        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockStreamInterface);

        $response = new Response($mockResponse);

        $username = 'scothis';
        $endpoint = sprintf('/%s/%s/%s', Datasets::API_NAME, Datasets::API_VERSION, $username);
        $accessToken = 'pk.eyJ1Ijoic2NvdGhpcyIsImEiOiJjaWp1Y2ltYmUwMDBicmJrdDQ4ZDBkaGN4In0.sbihZCZJ56-fsFNKHXF8YQ';

        $mockClient = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([$accessToken])
            ->getMock();
        $mockClient->expects($this->once())
            ->method('getAccessToken')
            ->willReturn($accessToken);

        $mockDatasets = $this->getMockBuilder(Datasets::class)
            ->setConstructorArgs([$mockClient])
            ->onlyMethods(['post'])
            ->getMock();

        $mockDatasets->expects($this->once())
            ->method('post')
            ->with($endpoint)
            ->willReturn($response);

        $apiResponse = $mockDatasets->create(['name' => 'foo', 'description' => 'bar']);

        $this->assertSame(200, $apiResponse->getStatusCode());
        $this->assertSame(['Content-Type' => ['application/json']], $apiResponse->getHeaders());
        $this->assertSame($this->mockCreateResponseData(), $apiResponse->getContent());
    }

    /**
     * @link: https://docs.mapbox.com/api/maps/datasets/#example-response-list-datasets
     */
    private function mockListResponseData(): string
    {
        return '[
            {
              "owner": "scothis",
              "id": "1234",
              "created": "2023-12-18T14:24:33.296Z",
              "modified": "2023-12-18T14:24:33.296Z",
              "bounds": [-10, -10, 10, 10],
              "features": 100,
              "size": 409600,
              "name": "foo",
              "description": "bar"
            },
            {
              "owner": "scothis",
              "id": "5678",
              "created": "2023-12-18T14:24:33.296Z",
              "modified": "2023-12-18T14:24:33.296Z",
              "bounds": [-10, -10, 10, 10],
              "features": 100,
              "size": 409600,
              "name": "baz",
              "description": "foo-bar"
            }
          ]';
    }

    /**
     * @link: https://docs.mapbox.com/api/maps/datasets/#example-response-retrieve-a-dataset
     */
    private function mockRetrieveResponseData(): string
    {
        return '{
            "owner": "scothis",
            "id": "1234",
            "created": "2023-12-18T14:24:33.296Z",
            "modified": "2023-12-18T14:24:33.296Z",
            "bounds": [-10, -10, 10, 10],
            "features": 100,
            "size": 409600,
            "name": "foo",
            "description": "bar"
          }';
    }

    /**
     * @link: https://docs.mapbox.com/api/maps/datasets/#example-response-create-a-dataset
     */
    private function mockCreateResponseData(): string
    {
        return '{
            "owner": "scothis",
            "id": "1234",
            "created": "2023-12-18T14:24:33.296Z",
            "modified": "2023-12-18T14:24:33.296Z",
            "bounds": [-10, -10, 10, 10],
            "features": 100,
            "size": 409600,
            "name": "foo",
            "description": "bar"
          }';
    }
}