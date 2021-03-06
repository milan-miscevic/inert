<?php

declare(strict_types=1);

namespace Mmm\Inert;

abstract class BaseFactory
{
    abstract public function __invoke(ServiceContainer $serviceContainer): object;
}
