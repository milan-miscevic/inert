<?php

namespace Inert\Exception;

class ControllerNotFound extends \RuntimeException implements ExceptionInterface
{
    protected $message = 'Controller can not be found.';
}
