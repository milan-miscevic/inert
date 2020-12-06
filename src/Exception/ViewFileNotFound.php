<?php

declare(strict_types=1);

namespace Mmm\Inert\Exception;

use DomainException;

class ViewFileNotFound extends DomainException implements ExceptionInterface
{
}
