<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests\Internal;

class Counter
{
    /** @var array<string, int> */
    private static array $calls = [];

    public static function reset(): void
    {
        self::$calls = [];
    }

    public static function incrementCalls(string $name): void
    {
        if (!isset(self::$calls[$name])) {
            self::$calls[$name] = 0;
        }

        self::$calls[$name]++;
    }

    public static function getCalls(string $name): int
    {
        return self::$calls[$name] ?? 0;
    }
}
