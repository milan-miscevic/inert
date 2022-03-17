<?php

declare(strict_types=1);

namespace Mmm\Inert;

interface ActionFactory extends ServiceFactory
{
    public function __invoke(ServiceContainer $serviceContainer): Action;
}
