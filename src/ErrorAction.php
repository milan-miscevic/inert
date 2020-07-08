<?php

declare(strict_types=1);

namespace Inert;

class ErrorAction extends BaseAction
{
    private \Exception $exception;

    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }

    public function run(): Response
    {
        return $this->render('error', ['exception' => $this->exception]);
    }
}
