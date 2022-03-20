<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Closure;
use Psr\Container\ContainerInterface;
use Throwable;

class ServiceContainer implements ContainerInterface
{
    /** @var (class-string|Closure)[] */
    private array $factories;

    /**
     * @param (class-string|Closure)[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    public function has(string $id): bool
    {
        return isset($this->factories[$id]);
    }

    public function get(string $id): object
    {
        if (!$this->has($id)) {
            throw new Exception\ServiceNotFound();
        }

        try {
            if ($this->factories[$id] instanceof Closure) {
                /** @var object $service */
                $service = call_user_func_array($this->factories[$id], [$this]);
            } else {
                /** @psalm-suppress MixedMethodCall */
                $serviceOrFactory = new $this->factories[$id]();

                if ($serviceOrFactory instanceof ServiceFactory) {
                    /**
                     * @var object $service
                     * @psalm-suppress UnnecessaryVarAnnotation
                     */
                    $service = call_user_func_array($serviceOrFactory, [$this]);
                } else {
                    $service = $serviceOrFactory;
                }
            }

            return $service;
        } catch (Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
