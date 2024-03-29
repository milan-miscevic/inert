<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Mmm\Inert\Exception\ViewFileNotFound;

trait RenderableTrait
{
    private ?string $viewFolder = null;

    public function setViewFolder(?string $viewFolder): void
    {
        $this->viewFolder = $viewFolder;
    }

    /**
     * @param mixed[] $args
     */
    public function render(string $file, array $args = []): Response
    {
        $viewFolder = $this->viewFolder === null
            ? dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'view'
            : $this->viewFolder;

        $viewFile = $viewFolder . DIRECTORY_SEPARATOR . $file . '.php';

        if (!file_exists($viewFile)) {
            throw new ViewFileNotFound(ViewFileNotFound::class . ': ' . $file);
        }

        extract($args);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_contents();
        ob_end_clean();

        return new Response($content);
    }
}
