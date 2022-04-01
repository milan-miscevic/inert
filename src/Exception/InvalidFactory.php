<?php

declare(strict_types=1);

namespace Mmm\Inert\Exception;

use DomainException;
use Psr\Container\ContainerExceptionInterface;

class InvalidFactory extends DomainException implements ContainerExceptionInterface, ExceptionInterface
{
}
