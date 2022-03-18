<?php

declare(strict_types=1);

namespace Mmm\Inert\Tests;

use Mmm\Inert\Action;
use Mmm\Inert\ActionContainer;
use Mmm\Inert\Application;
use Mmm\Inert\Exception\ActionNotFound;
use Mmm\Inert\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    private const ERROR_MESSAGE = 'This is an error page.';
    private const SUCCESSFUL_MESSAGE = 'This is a text.';

    public function testActionSuccessful(): void
    {
        /** @var ActionContainer&MockObject */
        $actionContainer = $this->getMockBuilder(ActionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $action = function (): Action {
            return new class() implements Action {
                public function run(): Response
                {
                    return new Response('This is a text.', []);
                }
            };
        };

        $actionContainer->method('get')
            ->willReturnCallback($action);

        $application = new Application($actionContainer, '');

        ob_start();
        $application->run();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame(self::SUCCESSFUL_MESSAGE, $content);
    }

    public function testActionNotFound(): void
    {
        /** @var ActionContainer&MockObject */
        $actionContainer = $this->getMockBuilder(ActionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $actionContainer->method('get')
            ->willThrowException(new ActionNotFound());

        $viewFolder = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view';
        $application = new Application($actionContainer, $viewFolder);

        ob_start();
        $application->run();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame(self::ERROR_MESSAGE, $content);
    }
}
