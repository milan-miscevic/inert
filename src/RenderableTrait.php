<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Mmm\Inert\Exception\ViewFileNotFound;

trait RenderableTrait
{
    private string $viewFolder = '';

    public function setViewFolder(string $viewFolder): void
    {
        $this->viewFolder = $viewFolder;
    }

    /**
     * @param mixed[] $args
     */
    public function render(string $file, array $args = []): Response
    {
        $viewFile = $this->viewFolder . DIRECTORY_SEPARATOR . $file . '.php';

        if (!file_exists($viewFile)) {
            throw new ViewFileNotFound();
        }

        extract($args);

        ob_start();
        require $viewFile;
        $content = (string) ob_get_contents();
        ob_end_clean();

        return new Response($content);
    }
}
