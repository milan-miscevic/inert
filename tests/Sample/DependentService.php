<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

class DependentService
{
    public function __construct(SimpleService $simpleService)
    {
        $simpleService->simpleMethod();
    }
}
