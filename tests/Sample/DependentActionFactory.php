<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\ActionFactory;
use Mmm\Inert\ServiceContainer;

class DependentActionFactory implements ActionFactory
{
    public function __invoke(ServiceContainer $serviceContainer): DependentAction
    {
        /** @var SimpleService */
        $simpleService = $serviceContainer->get(SimpleService::class);

        return new DependentAction($simpleService);
    }
}
