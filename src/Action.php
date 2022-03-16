<?php

declare(strict_types=1);

namespace Mmm\Inert;

interface Action
{
    public function run(): Response;
}
