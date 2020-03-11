<?php

namespace Inert\Exception;

class ActionNotFound extends \RuntimeException implements ExceptionInterface
{
    protected $message = 'Action can not be found.';
}
