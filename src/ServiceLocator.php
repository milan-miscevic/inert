<?php

namespace Inert;

use Inert\Exception\ServiceNotFound;

class ServiceLocator
{
    protected $factories;
    protected $config;

    public function __construct($factories, $config)
    {
        $this->factories = $factories;
        $this->config = $config;
    }

    public function get(string $id): object
    {
        if (!isset($this->factories[$id])) {
            throw new ServiceNotFound();
        }

        return call_user_func_array(
            $this->factories[$id],
            [
                $this,
                $this->config,
            ]
        );
    }
}
