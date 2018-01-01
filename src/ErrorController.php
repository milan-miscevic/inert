<?php

namespace Inert;

class ErrorController extends Controller
{
    protected $exception;

    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    public function indexAction()
    {
        $this->render('index', ['exception' => $this->exception]);
    }
}
