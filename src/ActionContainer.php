<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Closure;
use Throwable;

class ActionContainer
{
    /** @var (class-string<BaseAction>|BaseActionFactory|Closure)[] */
    private array $factories;

    private ServiceContainer $serviceContainer;
    private string $viewFolder;

    /**
     * @param (class-string<BaseAction>|BaseActionFactory|Closure)[] $factories
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
            $factory = $this->factories[$id];

            if (is_string($factory)) {
                /** @psalm-suppress UnsafeInstantiation */
                $factory = new $factory();
            }

            if ($factory instanceof BaseActionFactory || $factory instanceof Closure) {
                $factory = call_user_func_array($factory, [$this->serviceContainer]);
            }

            $factory->setViewFolder($this->viewFolder);

            return $factory;
        } catch (Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
