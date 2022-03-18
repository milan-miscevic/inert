<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Closure;
use Throwable;

class ActionContainer
{
    /** @var (class-string|Closure)[] */
    private array $factories;

    private ServiceContainer $serviceContainer;
    private string $viewFolder;

    /**
     * @param (class-string|Closure)[] $factories
     */
    public function __construct(array $factories, ServiceContainer $serviceContainer, string $viewFolder)
    {
        $this->factories = $factories;
        $this->serviceContainer = $serviceContainer;
        $this->viewFolder = $viewFolder;
    }

    public function get(string $id): Action
    {
        if (!isset($this->factories[$id])) {
            throw new Exception\ActionNotFound();
        }

        try {
            $factory = $this->factories[$id];

            if (is_string($factory)) {
                /** @psalm-suppress MixedMethodCall */
                $factory = new $factory();
            }

            if ($factory instanceof ActionFactory || $factory instanceof Closure) {
                $factory = call_user_func_array($factory, [$this->serviceContainer]);
            }

            if ($factory instanceof Renderable) {
                $factory->setViewFolder($this->viewFolder);
            }

            /** @var Action $factory */
            return $factory;
        } catch (Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
