<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\Action;
use Mmm\Inert\Response;

class SimpleAction implements Action
{
    public function run(): Response
    {
        return new Response('');
    }
}
