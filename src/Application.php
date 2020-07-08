<?php

declare(strict_types=1);

namespace Inert;

class Application
{
    private ActionLocator $actionLocator;
    private string $viewFolder;

    public function __construct(ActionLocator $actionLocator, string $viewFolder)
    {
        $this->actionLocator = $actionLocator;
        $this->viewFolder = $viewFolder;
    }

    public function run(): void
    {
        try {
            $name = $_GET['action'] ?? 'index';
            $response = $this->actionLocator->get($name)->run();
        } catch (\Exception $ex) {
            $errorAction = new ErrorAction($ex);
            $errorAction->setViewFolder($this->viewFolder);
            $response = $errorAction->run();
        }

        $response->render();
    }
}
