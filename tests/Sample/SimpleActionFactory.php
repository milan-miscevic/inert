<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

use Inert\BaseFactory;
use Inert\ServiceLocator;

class SimpleActionFactory extends BaseFactory
{
    public function __invoke(ServiceLocator $serviceLocator): SimpleAction
    {
        return new SimpleAction();
    }
}
