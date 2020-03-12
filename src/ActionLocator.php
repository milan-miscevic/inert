<?php

namespace Inert;

use Inert\Exception\ActionNotFound;

class ActionLocator
{
    private array $factories;
    private ServiceLocator $serviceLocator;

    public function __construct(array $factories, ServiceLocator $serviceLocator)
    {
        $this->factories = $factories;
        $this->serviceLocator = $serviceLocator;
    }

    public function get(string $id): object
    {
        if (!isset($this->factories[$id])) {
            throw new ActionNotFound();
        }

        return call_user_func_array($this->factories[$id], [$this->serviceLocator]);
    }
}
