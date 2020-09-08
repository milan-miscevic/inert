<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\ActionContainer;
use Inert\Exception\ActionNotFound;
use Inert\Exception\InvalidFactory;
use Inert\ServiceContainer;
use Inert\Tests\Sample\DependentAction;
use Inert\Tests\Sample\DependentActionFactory;
use Inert\Tests\Sample\SimpleAction;
use Inert\Tests\Sample\SimpleService;
use PHPUnit\Framework\TestCase;

class ActionContainerTest extends TestCase
{
    const SIMPLE = 'simple';
    const DEPENDENT = 'dependent';

    public function testClassDefinition(): void
    {
        $config = [
            self::SIMPLE => SimpleAction::class,
        ];

        $actionContainer = new ActionContainer($config, new ServiceContainer([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionContainer->get(self::SIMPLE));
    }

    public function testFunctionDefinition(): void
    {
        $config = [
            self::SIMPLE => function () {
                return new SimpleAction();
            },
        ];

        $actionContainer = new ActionContainer($config, new ServiceContainer([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionContainer->get(self::SIMPLE));
    }

    public function testFactoryDefinition(): void
    {
        $services = [
            SimpleService::class => SimpleService::class,
        ];

        $actions = [
            self::DEPENDENT => DependentActionFactory::class,
        ];

        $actionContainer = new ActionContainer($actions, new ServiceContainer($services), '');

        $this->assertInstanceOf(DependentAction::class, $actionContainer->get(self::DEPENDENT));
    }

    public function testActionNotFound(): void
    {
        $config = [];

        $actionContainer = new ActionContainer($config, new ServiceContainer([]), '');

        $this->expectException(ActionNotFound::class);
        $this->expectExceptionCode(0);

        $actionContainer->get(self::SIMPLE);
    }

    public function testInvalidFactory(): void
    {
        $config = [
            self::SIMPLE => function () {
                return null;
            },
        ];

        $actionContainer = new ActionContainer($config, new ServiceContainer([]), '');

        $this->expectException(InvalidFactory::class);
        $this->expectExceptionCode(0);

        $actionContainer->get(self::SIMPLE);
    }
}
