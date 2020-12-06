<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Mmm\Inert\Exception\ViewFileNotFound;

abstract class BaseAction
{
    private string $viewFolder;

    public function setViewFolder(string $viewFolder): void
    {
        $this->viewFolder = $viewFolder;
    }

    abstract public function run(): Response;

    /**
     * @param mixed[] $args
     */
    protected function render(string $file, array $args = []): Response
    {
        $viewFile = $this->viewFolder . DIRECTORY_SEPARATOR . $file . '.php';

        if (!file_exists($viewFile)) {
            throw new ViewFileNotFound();
        }

        extract($args);

        ob_start();
        require $viewFile;
        $content = ob_get_contents();
        ob_end_clean();

        if ($content === false) {
            $content = '';
        }

        return new Response($content);
    }
}
