<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\ServiceContainer;
use Mmm\Inert\ServiceFactory;

class DependentServiceFactory implements ServiceFactory
{
    public function __invoke(ServiceContainer $serviceContainer): DependentService
    {
        /** @var SimpleService */
        $simpleService = $serviceContainer->get(SimpleService::class);

        return new DependentService($simpleService);
    }
}
