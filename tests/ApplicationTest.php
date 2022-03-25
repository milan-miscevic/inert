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
    private const SUCCESSFUL_MESSAGE = 'This is a text.';

    public function testActionSuccessful(): void
    {
        /** @var ActionContainer&MockObject */
        $actionContainer = $this->getMockBuilder(ActionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $response = new Response(self::SUCCESSFUL_MESSAGE, []);

        $action = function () use ($response): Action {
            return new class($response) implements Action {
                private Response $response;

                public function __construct(Response $response)
                {
                    $this->response = $response;
                }

                public function run(): Response
                {
                    return $this->response;
                }
            };
        };

        $actionContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('index'))
            ->willReturnCallback($action);

        $application = new Application($actionContainer, '');

        $this->assertSame($response, $application->run());
    }

    public function testActionNotFound(): void
    {
        $actionId = 'non-existing';
        $_GET['action'] = $actionId;

        /** @var ActionContainer&MockObject */
        $actionContainer = $this->getMockBuilder(ActionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $actionContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo($actionId))
            ->willThrowException(new ActionNotFound(ActionNotFound::class . ': ' . $actionId));

        $application = new Application($actionContainer);

        $this->assertSame(
            'Error: Mmm\Inert\Exception\ActionNotFound: non-existing',
            $application->run()->getContent()
        );
    }
}
