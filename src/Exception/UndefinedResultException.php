<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Exception;

use DomainException;

/**
 * Thrown when an operation has no defined result, for example the logarithm of zero.
 */
final class UndefinedResultException extends DomainException implements ComplexException
{
}
