<?php

namespace Inert;

use Inert\Exception\ServiceNotFound;

class ServiceLocator
{
    protected $factories;

    public function __construct($factories)
    {
        $this->factories = $factories;
    }

    public function get(string $id): object
    {
        if (!isset($this->factories[$id])) {
            throw new ServiceNotFound();
        }

        return call_user_func_array($this->factories[$id], [$this]);
    }
}
