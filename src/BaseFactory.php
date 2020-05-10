<?php

namespace Inert;

abstract class BaseFactory
{
    abstract public function __invoke(ServiceLocator $serviceLocator): object;
}
