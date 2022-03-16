<?php

declare(strict_types=1);

namespace Mmm\Inert;

use Exception;

class ErrorAction implements Action, Renderable
{
    use RenderableTrait;

    private Exception $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function run(): Response
    {
        return $this->render('error', ['exception' => $this->exception]);
    }
}
