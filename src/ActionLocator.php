<?php

declare(strict_types=1);

namespace Inert;

class ActionLocator
{
    private array $factories;
    private ServiceLocator $serviceLocator;

    public function __construct(array $factories, ServiceLocator $serviceLocator)
    {
        $this->factories = $factories;
        $this->serviceLocator = $serviceLocator;
    }

    public function get(string $id): BaseAction
    {
        if (!isset($this->factories[$id])) {
            throw new Exception\ActionNotFound();
        }

        try {
            if (is_string($this->factories[$id])) {
                $this->factories[$id] = new $this->factories[$id]();
            }

            if ($this->factories[$id] instanceof BaseFactory || $this->factories[$id] instanceof \Closure) {
                $this->factories[$id] = call_user_func_array($this->factories[$id], [$this->serviceLocator]);
            }

            return $this->factories[$id];
        } catch (\Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
