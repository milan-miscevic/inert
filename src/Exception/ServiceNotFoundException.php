<?php

namespace Inert\Exception;

class ServiceNotFoundException extends \DomainException implements ExceptionInterface
{
    protected $message = 'Service can not be found.';
}
