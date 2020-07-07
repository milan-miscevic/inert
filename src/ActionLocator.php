<?php

declare(strict_types=1);

namespace Inert;

class ActionLocator
{
    /** @var (string|BaseFactory|\Closure|BaseAction)[] */
    private array $factories;

    private ServiceLocator $serviceLocator;
    private string $viewFolder;

    /**
     * @param (string|BaseFactory|\Closure)[] $factories
     */
    public function __construct(array $factories, ServiceLocator $serviceLocator, string $viewFolder)
    {
        $this->factories = $factories;
        $this->serviceLocator = $serviceLocator;
        $this->viewFolder = $viewFolder;
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

            $this->factories[$id]->setViewFolder($this->viewFolder);

            return $this->factories[$id];
        } catch (\Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
