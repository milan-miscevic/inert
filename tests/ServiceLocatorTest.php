<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\Exception\InvalidFactory;
use Inert\Exception\ServiceNotFound;
use Inert\ServiceLocator;
use Inert\Tests\Sample\DependentService;
use Inert\Tests\Sample\DependentServiceFactory;
use Inert\Tests\Sample\SimpleService;
use PHPUnit\Framework\TestCase;

class ServiceLocatorTest extends TestCase
{
    public function testClassDefinition(): void
    {
        $config = [
            SimpleService::class => SimpleService::class,
        ];

        $serviceLocator = new ServiceLocator($config);

        $this->assertInstanceOf(SimpleService::class, $serviceLocator->get(SimpleService::class));
    }

    public function testFunctionDefinition(): void
    {
        $config = [
            DependentService::class => function (ServiceLocator $serviceLocator) {
                return new DependentService(new SimpleService());
            },
        ];

        $serviceLocator = new ServiceLocator($config);

        $this->assertInstanceOf(DependentService::class, $serviceLocator->get(DependentService::class));
    }

    public function testFactoryDefinition(): void
    {
        $config = [
            DependentService::class => DependentServiceFactory::class,
        ];

        $serviceLocator = new ServiceLocator($config);

        $this->assertInstanceOf(DependentService::class, $serviceLocator->get(DependentService::class));
    }

    public function testServiceNotFound(): void
    {
        $config = [];

        $serviceLocator = new ServiceLocator($config);

        $this->expectException(ServiceNotFound::class);

        $serviceLocator->get(SimpleService::class);
    }

    public function testInvalidFactory(): void
    {
        $config = [
            SimpleService::class => function (ServiceLocator $serviceLocator) {
                return null;
            },
        ];

        $serviceLocator = new ServiceLocator($config);

        $this->expectException(InvalidFactory::class);

        $serviceLocator->get(SimpleService::class);
    }
}
