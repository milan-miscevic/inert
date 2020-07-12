<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\ActionLocator;
use Inert\Exception\ActionNotFound;
use Inert\Exception\InvalidFactory;
use Inert\ServiceLocator;
use Inert\Tests\Sample\DependentAction;
use Inert\Tests\Sample\DependentActionFactory;
use Inert\Tests\Sample\SimpleAction;
use Inert\Tests\Sample\SimpleService;
use PHPUnit\Framework\TestCase;

class ActionLocatorTest extends TestCase
{
    public function testClassDefinition(): void
    {
        $config = [
            SimpleAction::class => SimpleAction::class,
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionLocator->get(SimpleAction::class));
    }

    public function testFunctionDefinition(): void
    {
        $config = [
            SimpleAction::class => function () {
                return new SimpleAction();
            },
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionLocator->get(SimpleAction::class));
    }

    public function testFactoryDefinition(): void
    {
        $services = [
            SimpleService::class => SimpleService::class,
        ];

        $actions = [
            DependentAction::class => DependentActionFactory::class,
        ];

        $actionLocator = new ActionLocator($actions, new ServiceLocator($services), '');

        $this->assertInstanceOf(DependentAction::class, $actionLocator->get(DependentAction::class));
    }

    public function testActionNotFound(): void
    {
        $config = [];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->expectException(ActionNotFound::class);
        $this->expectExceptionCode(0);

        $actionLocator->get(SimpleAction::class);
    }

    public function testInvalidFactory(): void
    {
        $config = [
            SimpleAction::class => function () {
                return null;
            },
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->expectException(InvalidFactory::class);
        $this->expectExceptionCode(0);

        $actionLocator->get(SimpleAction::class);
    }
}
