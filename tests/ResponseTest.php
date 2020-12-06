<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\Response;
use Mmm\Inert\Tests\Internal\Counter;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    const CONTENT = 'Content';

    protected function setUp(): void
    {
        Counter::reset();
    }

    public function testWithHeaders(): void
    {
        require_once 'Internal' . DIRECTORY_SEPARATOR . 'header.php';

        $headers = ['content-type' => 'text/html'];
        $response = new Response(static::CONTENT, $headers);

        ob_start();
        $response->render();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame(static::CONTENT, $content);
        $this->assertSame(count($headers), Counter::getCalls('header'));
    }
}
