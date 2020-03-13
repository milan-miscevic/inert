<?php

namespace Inert;

abstract class Action
{
    abstract public function run(): void;

    protected function render(string $file, array $args = []): void
    {
        extract($args);

        require '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
