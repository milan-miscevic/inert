<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Closure;
use Throwable;

class ServiceContainer
{
    /** @var (class-string|BaseFactory|Closure)[] */
    private array $factories;

    /**
     * @param (class-string|BaseFactory|Closure)[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    public function get(string $id): object
    {
        if (!isset($this->factories[$id])) {
            throw new Exception\ServiceNotFound();
        }

        try {
            $factory = $this->factories[$id];

            if (is_string($factory)) {
                /** @psalm-suppress MixedMethodCall */
                $factory = new $factory();
            }

            if ($factory instanceof BaseFactory || $factory instanceof Closure) {
                $factory = call_user_func_array($factory, [$this]);
            }

            return $factory;
        } catch (Throwable $ex) {
            throw new Exception\InvalidFactory('', 0, $ex);
        }
    }
}
