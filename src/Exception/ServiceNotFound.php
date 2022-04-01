<?php

declare(strict_types=1);

namespace Mmm\Inert\Exception;

use DomainException;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFound extends DomainException implements NotFoundExceptionInterface, ExceptionInterface
{
}
