<?php

declare(strict_types=1);

namespace Inert;

use Inert\Tests\Internal\Counter;

function header(string $header): void
{
    Counter::incrementCalls('header');
}
