<?php

namespace Inert;

class Action
{
    protected function render($file, $args = [])
    {
        extract($args);

        require '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
