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
    const SIMPLE = 'simple';
    const DEPENDENT = 'dependent';

    public function testClassDefinition(): void
    {
        $config = [
            self::SIMPLE => SimpleAction::class,
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionLocator->get(self::SIMPLE));
    }

    public function testFunctionDefinition(): void
    {
        $config = [
            self::SIMPLE => function () {
                return new SimpleAction();
            },
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionLocator->get(self::SIMPLE));
    }

    public function testFactoryDefinition(): void
    {
        $services = [
            SimpleService::class => SimpleService::class,
        ];

        $actions = [
            self::DEPENDENT => DependentActionFactory::class,
        ];

        $actionLocator = new ActionLocator($actions, new ServiceLocator($services), '');

        $this->assertInstanceOf(DependentAction::class, $actionLocator->get(self::DEPENDENT));
    }

    public function testActionNotFound(): void
    {
        $config = [];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->expectException(ActionNotFound::class);
        $this->expectExceptionCode(0);

        $actionLocator->get(self::SIMPLE);
    }

    public function testInvalidFactory(): void
    {
        $config = [
            self::SIMPLE => function () {
                return null;
            },
        ];

        $actionLocator = new ActionLocator($config, new ServiceLocator([]), '');

        $this->expectException(InvalidFactory::class);
        $this->expectExceptionCode(0);

        $actionLocator->get(self::SIMPLE);
    }
}
