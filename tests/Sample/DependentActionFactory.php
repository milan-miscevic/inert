<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

use Inert\BaseFactory;
use Inert\ServiceLocator;

class DependentActionFactory extends BaseFactory
{
    public function __invoke(ServiceLocator $serviceLocator): DependentAction
    {
        /** @var SimpleService */
        $simpleService = $serviceLocator->get(SimpleService::class);

        return new DependentAction($simpleService);
    }
}
