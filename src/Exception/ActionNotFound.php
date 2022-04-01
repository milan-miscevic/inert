<?php

declare(strict_types=1);

namespace Mmm\Inert\Exception;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

class ActionNotFound extends RuntimeException implements NotFoundExceptionInterface, ExceptionInterface
{
}
