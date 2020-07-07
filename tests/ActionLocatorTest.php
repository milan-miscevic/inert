<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\ActionLocator;
use Inert\Exception\ActionNotFound;
use Inert\Exception\InvalidFactory;
use Inert\ServiceLocator;
use Inert\Tests\Sample\SimpleAction;
use Inert\Tests\Sample\SimpleActionFactory;
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
            SimpleAction::class => function (ServiceLocator $serviceLocator) {
                return new SimpleAction();
            },
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionLocator->get(SimpleAction::class));
    }

    public function testFactoryDefinition(): void
    {
        $config = [
            SimpleAction::class => SimpleActionFactory::class,
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionLocator->get(SimpleAction::class));
    }

    public function testActionNotFound(): void
    {
        $config = [];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->expectException(ActionNotFound::class);

        $actionLocator->get(SimpleAction::class);
    }

    public function testInvalidFactory(): void
    {
        $config = [
            SimpleAction::class => function (ServiceLocator $serviceLocator) {
                return null;
            },
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->expectException(InvalidFactory::class);

        $actionLocator->get(SimpleAction::class);
    }
}
