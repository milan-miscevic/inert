<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Mmm\Inert\Tests\Internal\Counter;

/** @psalm-suppress UnusedParam */
function header(string $header): void
{
    Counter::incrementCalls('header');
}
