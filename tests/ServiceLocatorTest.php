<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\Exception\InvalidFactory;
use Mmm\Inert\Exception\ServiceNotFound;
use Mmm\Inert\ServiceContainer;
use Mmm\Inert\Tests\Sample\DependentService;
use Mmm\Inert\Tests\Sample\DependentServiceFactory;
use Mmm\Inert\Tests\Sample\SimpleService;
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
