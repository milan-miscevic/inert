<?php

namespace Inert;

use Inert\Exception\ActionNotFound;
use Inert\Exception\InvalidFactory;

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

        try {
            if (is_string($this->factories[$id])) {
                $this->factories[$id] = new $this->factories[$id]();
            }

            return call_user_func_array($this->factories[$id], [$this->serviceLocator]);
        } catch (\Throwable $ex) {
            throw new InvalidFactory();
        }
    }
}
