<?php

namespace Inert\Exception;

class InvalidFactory extends \RuntimeException implements ExceptionInterface
{
    protected $message = 'Invalid factory is registered.';
}
