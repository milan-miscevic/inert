<?php

namespace Inert;

use Exception;

class ErrorAction extends Action
{
    protected Exception $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function run(): void
    {
        $this->render('error', ['exception' => $this->exception]);
    }
}
