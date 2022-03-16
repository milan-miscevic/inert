<?php

declare(strict_types=1);

namespace Mmm\Inert;

interface Renderable
{
    public function setViewFolder(string $viewFolder): void;

    /**
     * @param mixed[] $args
     */
    public function render(string $file, array $args = []): Response;
}
