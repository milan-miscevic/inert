<?php

namespace Inert\Exception;

class ActionNotFoundException extends \RuntimeException implements InertExceptionInterface
{
    protected $message = 'Action can not be found.';
}
