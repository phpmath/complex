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
 * Thrown when an operation would divide by the complex number zero.
 */
final class DivisionByZeroException extends InvalidArgumentException implements ComplexException
{
}
