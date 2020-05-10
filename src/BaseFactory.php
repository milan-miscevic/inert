<?php

declare(strict_types=1);

namespace Inert;

abstract class BaseFactory
{
    abstract public function __invoke(ServiceLocator $serviceLocator): object;
}
