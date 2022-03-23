<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Exception;

class Application
{
    private ActionContainer $actionContainer;
    private string $viewFolder;

    public function __construct(ActionContainer $actionContainer, string $viewFolder)
    {
        $this->actionContainer = $actionContainer;
        $this->viewFolder = $viewFolder;
    }

    public function run(): Response
    {
        try {
            $name = (string) ($_GET['action'] ?? 'index');
            $response = $this->actionContainer->get($name)->run();
        } catch (Exception $ex) {
            $errorAction = new ErrorAction($ex);
            $errorAction->setViewFolder($this->viewFolder);
            $response = $errorAction->run();
        }

        return $response;
    }
}
