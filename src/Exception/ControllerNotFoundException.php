<?php

namespace Inert\Exception;

class ControllerNotFoundException extends \RuntimeException implements InertExceptionInterface
{
    protected $message = 'Controller can not be found.';
}
