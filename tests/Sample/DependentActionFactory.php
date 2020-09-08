<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

use Inert\BaseFactory;
use Inert\ServiceContainer;

class DependentActionFactory extends BaseFactory
{
    public function __invoke(ServiceContainer $serviceContainer): DependentAction
    {
        /** @var SimpleService */
        $simpleService = $serviceContainer->get(SimpleService::class);

        return new DependentAction($simpleService);
    }
}
