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

    /** @var ActionContainer&MockObject */
    protected $actionContainer;

    protected Application $application;

    protected function setUp(): void
    {
        $this->actionContainer = $this->getMockBuilder(ActionContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->application = new Application($this->actionContainer);
    }

    public function testActionSuccessful(): void
    {
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

        $this->actionContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo('index'))
            ->willReturnCallback($action);

        $this->assertSame($response, $this->application->run());
    }

    public function testActionNotFound(): void
    {
        $actionId = 'non-existing';
        $_GET['action'] = $actionId;

        $this->actionContainer->expects($this->once())
            ->method('get')
            ->with($this->equalTo($actionId))
            ->willThrowException(new ActionNotFound(ActionNotFound::class . ': ' . $actionId));

        $this->assertSame(
            'Error: Mmm\Inert\Exception\ActionNotFound: non-existing',
            $this->application->run()->getContent()
        );
    }
}
