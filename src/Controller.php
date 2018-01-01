<?php

namespace Inert;

class Controller
{
    protected function render($file, $args = [])
    {
        // extract folder name from controller's fqcn
        $folder = strtolower(substr(static::class, strrpos(static::class, '\\'), -10));

        extract($args);

        require '..' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR
            . $folder . DIRECTORY_SEPARATOR . $file . '.php';
    }
}
