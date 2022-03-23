<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\Action;
use Mmm\Inert\Exception\ViewFileNotFound;
use Mmm\Inert\Renderable;
use Mmm\Inert\RenderableTrait;
use Mmm\Inert\Response;
use PHPUnit\Framework\TestCase;

class RenderableTraitTest extends TestCase
{
    public function testSuccessful(): void
    {
        $renderableAction = new class() implements Action, Renderable {
            use RenderableTrait;

            public function run(): Response
            {
                return $this->render('success');
            }
        };

        $viewFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view';
        $renderableAction->setViewFolder($viewFolder);

        $this->assertSame("Successful view.\n", $renderableAction->run()->getContent());
    }

    public function testViewFileNotFound(): void
    {
        $renderableAction = new class() implements Action, Renderable {
            use RenderableTrait;

            public function run(): Response
            {
                return $this->render('non-existing');
            }
        };

        $viewFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view';
        $renderableAction->setViewFolder($viewFolder);

        $this->expectException(ViewFileNotFound::class);
        $this->expectExceptionCode(0);

        $renderableAction->run();
    }
}
