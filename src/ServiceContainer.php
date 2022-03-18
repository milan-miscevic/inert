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
            $factory = $this->factories[$id];

            if (is_string($factory)) {
                /** @psalm-suppress MixedMethodCall */
                $factory = new $factory();
            }

            if ($factory instanceof ServiceFactory || $factory instanceof Closure) {
                $factory = call_user_func_array($factory, [$this]);
            }

            /** @var object $factory */
            return $factory;
        } catch (Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
