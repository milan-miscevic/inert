<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\BaseAction;
use Mmm\Inert\Response;

class DependentAction extends BaseAction
{
    private SimpleService $simpleService;

    public function __construct(SimpleService $simpleService)
    {
        $this->simpleService = $simpleService;
    }

    public function run(): Response
    {
        return new Response($this->simpleService->simpleMethod());
    }
}
