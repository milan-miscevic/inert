<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\Action;
use Mmm\Inert\Renderable;
use Mmm\Inert\Response;

class RenderableAction implements Action, Renderable
{
    private string $viewFolder = '';

    public function run(): Response
    {
        return $this->render('non-existing');
    }

    public function setViewFolder(string $viewFolder): void
    {
        $this->viewFolder = $viewFolder;
    }

    public function render(string $file, array $args = []): Response
    {
        return new Response($this->viewFolder);
    }
}
