<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Tests\Complex;

use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\DivisionByZeroException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'divide')]
final class DivideTest extends TestCase
{
    public function testDividesNumbers(): void
    {
        // Arrange
        $a = Complex::of(-5.0, 10.0);
        $b = Complex::of(3.0, 4.0);

        // Act
        $result = $a->divide($b);

        // Assert
        self::assertEqualsWithDelta(1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(2.0, $result->imaginary(), 1.0E-12);
    }

    public function testDividesByNumberWithLargerImaginaryPart(): void
    {
        // Arrange
        $a = Complex::of(1.0, 1.0);
        $b = Complex::of(1.0, 2.0);

        // Act
        $result = $a->divide($b);

        // Assert
        self::assertEqualsWithDelta(0.6, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(-0.2, $result->imaginary(), 1.0E-12);
    }

    public function testDoesNotOverflowOnLargeDivisor(): void
    {
        // Arrange
        $a = Complex::of(1.0E+200, 1.0E+200);
        $b = Complex::of(1.0E+200, 1.0E+200);

        // Act
        $result = $a->divide($b);

        // Assert
        self::assertEqualsWithDelta(1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testThrowsOnDivisionByZero(): void
    {
        // Arrange
        $a = Complex::of(1.0, 1.0);
        $this->expectException(DivisionByZeroException::class);

        // Act
        $a->divide(Complex::zero());
    }
}
