<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\Response;
use Mmm\Inert\Tests\Internal\Counter;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private const CONTENT = 'Content';
    private const HEADERS = ['content-type' => 'text/html'];

    protected function setUp(): void
    {
        Counter::reset();
    }

    public function testWithHeaders(): void
    {
        /** @psalm-suppress MissingFile */
        require_once 'Internal' . DIRECTORY_SEPARATOR . 'header.php';

        $response = new Response(self::CONTENT, self::HEADERS);

        $this->assertSame(self::CONTENT, $response->getContent());
        $this->assertSame(self::HEADERS, $response->getHeaders());

        ob_start();
        $response->render();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame(count(self::HEADERS), Counter::getCalls('header'));
        $this->assertSame(self::CONTENT, $content);
    }
}
