<?php

namespace Inert;

use Exception;

class Application
{
    private ActionLocator $actionLocator;

    public function __construct(array $config)
    {
        $this->actionLocator = new ActionLocator(
            $config['actions'],
            new ServiceLocator($config['services'])
        );
    }

    public function run(): void
    {
        try {
            $name = $_GET['action'] ?? 'index';
            $this->actionLocator->get($name)->run();
        } catch (Exception $ex) {
            (new ErrorAction($ex))->run();
        }
    }
}
