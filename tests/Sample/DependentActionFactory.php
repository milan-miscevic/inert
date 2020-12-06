<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\BaseFactory;
use Mmm\Inert\ServiceContainer;

class DependentActionFactory extends BaseFactory
{
    public function __invoke(ServiceContainer $serviceContainer): DependentAction
    {
        /** @var SimpleService */
        $simpleService = $serviceContainer->get(SimpleService::class);

        return new DependentAction($simpleService);
    }
}
