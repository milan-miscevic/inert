<?php

declare(strict_types=1);

namespace Inert;

class Application
{
    private ActionLocator $actionLocator;

    public function __construct(ActionLocator $actionLocator)
    {
        $this->actionLocator = $actionLocator;
    }

    public function run(): void
    {
        try {
            $name = $_GET['action'] ?? 'index';
            $this->actionLocator->get($name)->run();
        } catch (\Exception $ex) {
            (new ErrorAction($ex))->run();
        }
    }
}
