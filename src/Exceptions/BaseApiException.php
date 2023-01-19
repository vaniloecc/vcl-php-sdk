<?php

declare(strict_types=1);

/**
 * Contains the BaseApiException class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-18
 *
 */

namespace VaniloCloud\Exceptions;

use RuntimeException;

abstract class BaseApiException extends RuntimeException
{
}
