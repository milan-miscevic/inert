<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Sample;

use Mmm\Inert\BaseAction;
use Mmm\Inert\Response;

class SimpleAction extends BaseAction
{
    public function run(): Response
    {
        return new Response('');
    }
}
