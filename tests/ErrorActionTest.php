<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\ErrorAction;
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

        $this->assertSame(self::ERROR_MESSAGE, $content);
    }
}
