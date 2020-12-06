<?php

declare(strict_types=1);

namespace Mmm\Inert\Exception;

use RuntimeException;

class ActionNotFound extends RuntimeException implements ExceptionInterface
{
}
