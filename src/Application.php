<?php

namespace Inert;

use Exception;
use Inert\Exception\ActionNotFound;
use Inert\Exception\ControllerNotFound;
use Inert\Exception\ServiceNotFound;

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
            } catch (ServiceNotFound $ex) {
                throw new ControllerNotFound();
            }

            $action = $this->query('action', 'index') . 'Action';

            if (method_exists($controller, $action)) {
                $controller->$action();
            } else {
                throw new ActionNotFound();
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
