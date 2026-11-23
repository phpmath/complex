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
#[CoversMethod(Complex::class, 'subtract')]
final class SubtractTest extends TestCase
{
    public function testSubtractsParts(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);
        $b = Complex::of(3.0, -5.0);

        // Act
        $result = $a->subtract($b);

        // Assert
        self::assertEqualsWithDelta(-2.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(7.0, $result->imaginary(), 1.0E-12);
    }

    public function testDoesNotChangeOriginal(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $a->subtract(Complex::one());

        // Assert
        self::assertSame(1.0, $a->real());
    }
}
