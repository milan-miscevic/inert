<?php

namespace Inert\Exception;

class ActionNotFound extends \DomainException implements ExceptionInterface
{
    protected $message = 'Action can not be found.';
}
