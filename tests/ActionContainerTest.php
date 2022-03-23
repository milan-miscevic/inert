<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\Action;
use Mmm\Inert\ActionContainer;
use Mmm\Inert\Exception\ActionNotFound;
use Mmm\Inert\Exception\InvalidFactory;
use Mmm\Inert\ServiceContainer;
use Mmm\Inert\Tests\Sample\DependentAction;
use Mmm\Inert\Tests\Sample\DependentActionFactory;
use Mmm\Inert\Tests\Sample\RenderableAction;
use Mmm\Inert\Tests\Sample\SimpleAction;
use Mmm\Inert\Tests\Sample\SimpleService;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ActionContainerTest extends TestCase
{
    const DEPENDENT = 'dependent';
    const RENDERABLE = 'renderable';
    const SIMPLE = 'simple';

    public function testClassDefinition(): void
    {
        $actions = [
            self::SIMPLE => SimpleAction::class,
        ];

        $actionContainer = new ActionContainer($actions, new ServiceContainer([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionContainer->get(self::SIMPLE));
    }

    public function testFactoryDefinition(): void
    {
        $actions = [
            self::DEPENDENT => DependentActionFactory::class,
        ];

        $services = [
            SimpleService::class => SimpleService::class,
        ];

        $actionContainer = new ActionContainer($actions, new ServiceContainer($services), '');

        $this->assertInstanceOf(DependentAction::class, $actionContainer->get(self::DEPENDENT));
    }

    public function testClosureDefinition(): void
    {
        $actions = [
            self::SIMPLE => function (): Action {
                return new SimpleAction();
            },
        ];

        $actionContainer = new ActionContainer($actions, new ServiceContainer([]), '');

        $this->assertInstanceOf(SimpleAction::class, $actionContainer->get(self::SIMPLE));
    }

    public function testRenderableClassDefinition(): void
    {
        $actions = [
            self::RENDERABLE => RenderableAction::class,
        ];

        $actionContainer = new ActionContainer($actions, new ServiceContainer([]), 'view-folder');

        $renderableAction = $actionContainer->get(self::RENDERABLE);
        $this->assertInstanceOf(RenderableAction::class, $renderableAction);
        $this->assertSame('view-folder', $renderableAction->run()->getContent());
    }

    public function testActionNotFound(): void
    {
        $actions = [];

        $actionContainer = new ActionContainer($actions, new ServiceContainer([]), '');

        $this->expectException(ActionNotFound::class);
        $this->expectExceptionCode(0);

        $actionContainer->get(self::SIMPLE);
    }

    public function testInvalidFactory(): void
    {
        $actions = [
            self::SIMPLE => function (): Action {
                throw new RuntimeException();
            },
        ];

        $actionContainer = new ActionContainer($actions, new ServiceContainer([]), '');

        $this->expectException(InvalidFactory::class);
        $this->expectExceptionCode(0);

        $actionContainer->get(self::SIMPLE);
    }
}
