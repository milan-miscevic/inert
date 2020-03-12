<?php

namespace Inert;

use Inert\Exception\ActionNotFound;

class ActionLocator
{
    private array $factories;
    private Dic $serviceLocator;
    private array $config;

    public function __construct(array $factories, Dic $serviceLocator, array $config)
    {
        $this->factories = $factories;
        $this->serviceLocator = $serviceLocator;
        $this->config = $config;
    }

    public function get(string $id): object
    {
        if (!isset($this->factories[$id])) {
            throw new ActionNotFound();
        }

        return call_user_func_array(
            $this->factories[$id],
            [
                $this->serviceLocator,
                $this->config,
            ]
        );
    }
}
