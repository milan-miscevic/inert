<?php

namespace Inert;

abstract class Action
{
    abstract public function run(): void;

    protected function render($file, $args = [])
    {
        extract($args);

        require '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
