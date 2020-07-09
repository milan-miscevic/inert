<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

use Inert\BaseFactory;
use Inert\ServiceLocator;

class DependentServiceFactory extends BaseFactory
{
    public function __invoke(ServiceLocator $serviceLocator): DependentService
    {
        /** @var SimpleService */
        $simpleService = $serviceLocator->get(SimpleService::class);

        return new DependentService($simpleService);
    }
}
