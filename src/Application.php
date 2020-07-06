<?php

declare(strict_types=1);

namespace Inert;

class Application
{
    private ActionLocator $actionLocator;

    /**
     * @param array[] $config
     */
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
        } catch (\Exception $ex) {
            (new ErrorAction($ex))->run();
        }
    }
}
