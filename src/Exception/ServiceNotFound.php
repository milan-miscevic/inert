<?php

declare(strict_types=1);

namespace Mmm\Inert\Exception;

use DomainException;

class ServiceNotFound extends DomainException implements ExceptionInterface
{
}
