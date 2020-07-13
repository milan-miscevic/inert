<?php

declare(strict_types=1);

namespace Inert\Tests\Internal;

class Counter
{
    /** @var array<string, int> */
    private static array $calls = [];

    public static function reset(): void
    {
        static::$calls = [];
    }

    public static function incrementCalls(string $name): void
    {
        if (!isset(static::$calls[$name])) {
            static::$calls[$name] = 0;
        }

        static::$calls[$name]++;
    }

    public static function getCalls(string $name): int
    {
        return static::$calls[$name];
    }
}
