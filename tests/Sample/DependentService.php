<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

class DependentService
{
    public function __construct(SimpleService $simpleService)
    {
        $simpleService->simpleMethod();
    }
}
