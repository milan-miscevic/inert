<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\ErrorAction;
use PHPUnit\Framework\TestCase;

class ErrorActionTest extends TestCase
{
    private const ERROR_MESSAGE = 'This is an error page.';

    public function testErrorPage(): void
    {
        $action = new ErrorAction(new \Exception());
        $action->setViewFolder(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view');

        ob_start();
        $action->run()->render();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame(static::ERROR_MESSAGE, $content);
    }
}
