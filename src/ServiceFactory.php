<?php

declare(strict_types=1);

namespace Mmm\Inert;

interface ServiceFactory
{
    public function __invoke(ServiceContainer $serviceContainer): object;
}
