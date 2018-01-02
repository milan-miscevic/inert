<?php

namespace Inert\Exception;

class ActionNotFoundException extends \RuntimeException implements ExceptionInterface
{
    protected $message = 'Action can not be found.';
}
