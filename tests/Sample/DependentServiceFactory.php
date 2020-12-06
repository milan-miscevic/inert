<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\BaseFactory;
use Mmm\Inert\ServiceContainer;

class DependentServiceFactory extends BaseFactory
{
    public function __invoke(ServiceContainer $serviceContainer): DependentService
    {
        /** @var SimpleService */
        $simpleService = $serviceContainer->get(SimpleService::class);

        return new DependentService($simpleService);
    }
}
