<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Tests\Complex;

use PHPMath\Complex\Complex;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'zero')]
final class ZeroTest extends TestCase
{
    public function testReturnsZero(): void
    {
        // Act
        $result = Complex::zero();

        // Assert
        self::assertSame(0.0, $result->real());
        self::assertSame(0.0, $result->imaginary());
    }
}
