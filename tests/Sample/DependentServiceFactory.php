<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

use Inert\BaseFactory;
use Inert\ServiceContainer;

class DependentServiceFactory extends BaseFactory
{
    public function __invoke(ServiceContainer $serviceContainer): DependentService
    {
        /** @var SimpleService */
        $simpleService = $serviceContainer->get(SimpleService::class);

        return new DependentService($simpleService);
    }
}
