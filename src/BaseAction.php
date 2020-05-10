<?php

declare(strict_types=1);

namespace Inert;

abstract class BaseAction
{
    abstract public function run(): void;

    protected function render(string $file, array $args = []): void
    {
        extract($args);

        require BASE_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
