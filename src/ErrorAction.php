<?php

namespace Inert;

class ErrorAction extends BaseAction
{
    private \Exception $exception;

    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }

    public function run(): void
    {
        $this->render('error', ['exception' => $this->exception]);
    }
}
