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

    abstract public function run(): Response;

    /**
     * @param mixed[] $args
     */
    protected function render(string $file, array $args = []): Response
    {
        extract($args);

        ob_start();
        require $this->viewFolder . DIRECTORY_SEPARATOR . $file . '.php';
        $content = ob_get_contents();
        ob_end_clean();

        if ($content === false) {
            $content = '';
        }

        return new Response($content);
    }
}
