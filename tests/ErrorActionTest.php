<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Exception;
use Mmm\Inert\ErrorAction;
use PHPUnit\Framework\TestCase;

class ErrorActionTest extends TestCase
{
    public function testErrorPage(): void
    {
        $exception = new Exception('General error');
        $action = new ErrorAction($exception);
        $action->setViewFolder(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view');

        ob_start();
        $action->run()->render();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame('Error: General error', $content);
    }
}
