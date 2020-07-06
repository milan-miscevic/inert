<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

class DependentService
{
    private SimpleService $simpleService;

    public function __construct(SimpleService $simpleService)
    {
        $this->simpleService = $simpleService;
    }
}
