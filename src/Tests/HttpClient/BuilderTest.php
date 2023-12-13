<?php

namespace MapboxApi\Tests\HttpClient;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use MapboxApi\HttpClient\Builder;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @author Liam Claridge <lclaridge4@gmail.com>
 */
class BuilderTest extends TestCase
{
    /**
     * @test ->getHttpClient()
     */
    public function testGetHttpClient()
    {
        $mockBuilder = $this->getMockBuilder(Builder::class)
            ->getMock();

        $this->assertInstanceOf(HttpMethodsClientInterface::class, $mockBuilder->getHttpClient());
    }

    /**
     * @test ->addPlugin()
     */
    public function testAddPlugin()
    {
        $builder = new Builder();

        $plugin = $this->createMock(Plugin::class);

        $builder->addPlugin($plugin);

        $this->assertContains($plugin, $this->getPrivateProperty($builder, 'plugins'));
    }

    /**
     * @test ->removePlugin()
     */
    public function testRemovePlugin()
    {
        $builder = new Builder();
        $plugin = $this->createMock(Plugin::class);
        $builder->addPlugin($plugin);

        $builder->removePlugin(get_class($plugin));

        $this->assertNotContains($plugin, $this->getPrivateProperty($builder, 'plugins'));
    }

    /**
     * Get private property of the object.
     *
     * @param object $object
     * @param string $propertyName
     * @return mixed
     */
    private function getPrivateProperty($object, $propertyName)
    {
        $reflector = new ReflectionClass($object);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}