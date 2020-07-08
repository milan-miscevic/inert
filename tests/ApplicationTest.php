<?php

declare(strict_types=1);

namespace Inert\Tests;

use Inert\ActionLocator;
use Inert\Application;
use Inert\BaseAction;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    private const ERROR_MESSAGE = 'This is a text.';

    public function testActionSuccessful(): void
    {
        /** @var ActionLocator&MockObject */
        $stub = $this->getMockBuilder(ActionLocator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $callback = function () {
            return new class extends BaseAction {
                public function run(): void
                {
                    echo 'This is a text.';
                }
            };
        };

        $stub->method('get')
            ->willReturnCallback($callback);

        $application = new Application($stub, '');

        ob_start();
        $application->run();
        $content = ob_get_contents();
        ob_end_clean();

        $this->assertSame(static::ERROR_MESSAGE, $content);
    }
}
