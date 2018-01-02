<?php

namespace Inert\Exception;

class ControllerNotFoundException extends \RuntimeException implements ExceptionInterface
{
    protected $message = 'Controller can not be found.';
}
