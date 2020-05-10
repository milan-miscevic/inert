<?php

declare(strict_types=1);

namespace Inert;

class ServiceLocator
{
    private array $factories;

    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    public function get(string $id): object
    {
        if (!isset($this->factories[$id])) {
            throw new Exception\ServiceNotFound();
        }

        try {
            if (is_string($this->factories[$id])) {
                $this->factories[$id] = new $this->factories[$id]();
            }

            if ($this->factories[$id] instanceof BaseFactory || $this->factories[$id] instanceof \Closure) {
                $this->factories[$id] = call_user_func_array($this->factories[$id], [$this]);
            }

            return $this->factories[$id];
        } catch (\Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
