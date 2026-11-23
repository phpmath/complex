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
#[CoversMethod(Complex::class, 'multiply')]
final class MultiplyTest extends TestCase
{
    public function testMultipliesNumbers(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);
        $b = Complex::of(3.0, 4.0);

        // Act
        $result = $a->multiply($b);

        // Assert
        self::assertEqualsWithDelta(-5.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(10.0, $result->imaginary(), 1.0E-12);
    }

    public function testImaginaryUnitSquaredIsMinusOne(): void
    {
        // Arrange
        $i = Complex::i();

        // Act
        $result = $i->multiply($i);

        // Assert
        self::assertEqualsWithDelta(-1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testDoesNotChangeOriginal(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $a->multiply(Complex::i());

        // Assert
        self::assertSame(2.0, $a->imaginary());
    }
}
