<?php

namespace Inert;

use Exception;
use Inert\Exception\ActionNotFoundException;
use Inert\Exception\ControllerNotFoundException;
use Inert\Exception\ServiceNotFoundException;

class Application
{
    protected $dic;

    public function __construct($config)
    {
        $this->dic = new Dic($config['dic'], $config['config']);
    }

    public function run()
    {
        try {
            try {
                $controller = $this->dic->get($this->query('controller', 'Index') . 'Controller');
            } catch (ServiceNotFoundException $ex) {
                throw new ControllerNotFoundException();
            }

            $action = $this->query('action', 'index') . 'Action';

            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                throw new ActionNotFoundException();
            }
        } catch (Exception $ex) {
            (new ErrorController($ex))->indexAction();
        }
    }

    protected function query($name, $default)
    {
        return $_GET[$name] ?? $default;
    }
}
