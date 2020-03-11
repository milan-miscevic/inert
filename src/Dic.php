<?php

namespace Inert;

use Inert\Exception\ServiceNotFound;

class Dic
{
    protected $callables;
    protected $config;

    public function __construct($callables, $config)
    {
        $this->callables = $callables;
        $this->config = $config;
    }

    public function get($id)
    {
        if (!isset($this->callables[$id])) {
            throw new ServiceNotFound();
        }

        return call_user_func_array(
            $this->callables[$id],
            [
                $this,
                $this->config,
            ]
        );
    }
}
