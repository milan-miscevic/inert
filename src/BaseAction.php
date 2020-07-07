<?php

declare(strict_types=1);

namespace Inert;

abstract class BaseAction
{
    private string $viewFolder;

    public function setViewFolder(string $viewFolder): void
    {
        $this->viewFolder = $viewFolder;
    }

    abstract public function run(): void;

    /**
     * @param mixed[] $args
     */
    protected function render(string $file, array $args = []): void
    {
        extract($args);

        require $this->viewFolder . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
