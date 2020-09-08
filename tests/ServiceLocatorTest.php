<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\Exception\InvalidFactory;
use Inert\Exception\ServiceNotFound;
use Inert\ServiceContainer;
use Inert\Tests\Sample\DependentService;
use Inert\Tests\Sample\DependentServiceFactory;
use Inert\Tests\Sample\SimpleService;
use PHPUnit\Framework\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testClassDefinition(): void
    {
        $config = [
            SimpleService::class => SimpleService::class,
        ];

        $serviceContainer = new ServiceContainer($config);

        $this->assertInstanceOf(SimpleService::class, $serviceContainer->get(SimpleService::class));
    }

    public function testFunctionDefinition(): void
    {
        $config = [
            DependentService::class => function () {
                return new DependentService(new SimpleService());
            },
        ];

        $serviceContainer = new ServiceContainer($config);

        $this->assertInstanceOf(DependentService::class, $serviceContainer->get(DependentService::class));
    }

    public function testFactoryDefinition(): void
    {
        $config = [
            DependentService::class => DependentServiceFactory::class,
            SimpleService::class => SimpleService::class,
        ];

        $serviceContainer = new ServiceContainer($config);

        $this->assertInstanceOf(DependentService::class, $serviceContainer->get(DependentService::class));
    }

    public function testServiceNotFound(): void
    {
        $config = [];

        $serviceContainer = new ServiceContainer($config);

        $this->expectException(ServiceNotFound::class);
        $this->expectExceptionCode(0);

        $serviceContainer->get(SimpleService::class);
    }

    public function testInvalidFactory(): void
    {
        $config = [
            SimpleService::class => function () {
                return null;
            },
        ];

        $serviceContainer = new ServiceContainer($config);

        $this->expectException(InvalidFactory::class);
        $this->expectExceptionCode(0);

        $serviceContainer->get(SimpleService::class);
    }
}
