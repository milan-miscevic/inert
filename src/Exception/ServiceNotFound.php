<?php

namespace Inert\Exception;

class ServiceNotFound extends \DomainException implements ExceptionInterface
{
    protected $message = 'Service can not be found.';
}
