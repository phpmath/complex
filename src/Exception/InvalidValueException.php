<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Exception;

use InvalidArgumentException;

/**
 * Thrown when an argument is not acceptable, for example a non-finite float.
 */
final class InvalidValueException extends InvalidArgumentException implements ComplexException
{
}
