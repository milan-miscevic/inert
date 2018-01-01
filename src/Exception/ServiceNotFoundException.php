<?php

namespace Inert\Exception;

class ServiceNotFoundException extends \DomainException implements InertExceptionInterface
{
    protected $message = 'Service can not be found.';
}
