<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

class DependentService
{
    private SimpleService $simpleService;

    public function __construct(SimpleService $simpleService)
    {
        $this->simpleService = $simpleService;
    }

    public function dependentMethod(): string
    {
        return $this->simpleService->simpleMethod();
    }
}
