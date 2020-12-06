<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Closure;
use Throwable;

class ActionContainer
{
    /** @var (string|BaseFactory|Closure|BaseAction)[] */
    private array $factories;

    private ServiceContainer $serviceContainer;
    private string $viewFolder;

    /**
     * @param (string|BaseFactory|Closure)[] $factories
     */
    public function __construct(array $factories, ServiceContainer $serviceContainer, string $viewFolder)
    {
        $this->factories = $factories;
        $this->serviceContainer = $serviceContainer;
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

            if ($this->factories[$id] instanceof BaseFactory || $this->factories[$id] instanceof Closure) {
                $this->factories[$id] = call_user_func_array($this->factories[$id], [$this->serviceContainer]);
            }

            $this->factories[$id]->setViewFolder($this->viewFolder);

            return $this->factories[$id];
        } catch (Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
