<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Closure;
use Mmm\Inert\Exception\ActionNotFound;
use Mmm\Inert\Exception\InvalidFactory;
use Psr\Container\ContainerInterface;
use Throwable;

class ActionContainer implements ContainerInterface
{
    /** @var (class-string|Closure)[] */
    private array $factories;

    private ServiceContainer $serviceContainer;
    private ?string $viewFolder;

    /**
     * @param (class-string|Closure)[] $factories
     */
    public function __construct(array $factories, ServiceContainer $serviceContainer, ?string $viewFolder = null)
    {
        $this->factories = $factories;
        $this->serviceContainer = $serviceContainer;
        $this->viewFolder = $viewFolder;
    }

    public function has(string $id): bool
    {
        return isset($this->factories[$id]);
    }

    public function get(string $id): Action
    {
        if (!$this->has($id)) {
            throw new ActionNotFound(ActionNotFound::class . ': ' . $id);
        }

        try {
            if ($this->factories[$id] instanceof Closure) {
                /** @var Action $action */
                $action = call_user_func_array($this->factories[$id], [$this->serviceContainer]);
            } else {
                /** @psalm-suppress MixedMethodCall */
                $actionOrFactory = new $this->factories[$id]();

                if ($actionOrFactory instanceof ServiceFactory) {
                    /**
                     * @var Action $action
                     * @psalm-suppress UnnecessaryVarAnnotation
                     */
                    $action = call_user_func_array($actionOrFactory, [$this->serviceContainer]);
                } else {
                    /** @var Action $action */
                    $action = $actionOrFactory;
                }
            }

            if ($action instanceof Renderable) {
                $action->setViewFolder($this->viewFolder);
            }

            return $action;
        } catch (Throwable $ex) {
            throw new InvalidFactory(InvalidFactory::class . ': ' . $ex->getMessage(), 0, $ex);
        }
    }
}
