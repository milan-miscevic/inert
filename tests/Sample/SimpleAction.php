<?php

declare(strict_types=1);

namespace Inert\Tests\Sample;

use Inert\BaseAction;
use Inert\Response;

class SimpleAction extends BaseAction
{
    public function run(): Response
    {
        return new Response('');
    }
}
