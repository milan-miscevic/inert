<?php

declare(strict_types=1);

namespace InertTest\Sample;

class DependentService
{
    private SimpleService $simpleService;

    public function __construct(SimpleService $simpleService)
    {
        $this->simpleService = $simpleService;
    }
}
