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
use PHPMath\Complex\Exception\InvalidValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

use const NAN;
use const PHP_INT_MIN;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'pow')]
final class PowTest extends TestCase
{
    public function testRaisesToPositiveInteger(): void
    {
        // Arrange
        $a = Complex::of(1.0, 1.0);

        // Act
        $result = $a->pow(2);

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(2.0, $result->imaginary(), 1.0E-12);
    }

    public function testRaisesToLargerInteger(): void
    {
        // Arrange
        $a = Complex::of(1.0, 1.0);

        // Act
        $result = $a->pow(8);

        // Assert
        self::assertEqualsWithDelta(16.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testExponentZeroGivesOne(): void
    {
        // Arrange
        $a = Complex::of(3.0, 4.0);

        // Act
        $result = $a->pow(0);

        // Assert
        self::assertEqualsWithDelta(1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testRaisesToNegativeInteger(): void
    {
        // Arrange
        $a = Complex::of(0.0, 2.0);

        // Act
        $result = $a->pow(-1);

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(-0.5, $result->imaginary(), 1.0E-12);
    }

    public function testRaisesToRealExponent(): void
    {
        // Arrange
        $a = Complex::of(4.0, 0.0);

        // Act
        $result = $a->pow(0.5);

        // Assert
        self::assertEqualsWithDelta(2.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testRaisesToFractionalExponentOfNegativeNumber(): void
    {
        // Arrange
        $a = Complex::of(-1.0, 0.0);

        // Act
        $result = $a->pow(0.5);

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(1.0, $result->imaginary(), 1.0E-12);
    }

    public function testZeroToPowerZeroIsOne(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->pow(0.0);

        // Assert
        self::assertEqualsWithDelta(1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testZeroToPositiveRealExponentIsZero(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->pow(2.5);

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testThrowsOnZeroToNegativeInteger(): void
    {
        // Arrange
        $a = Complex::zero();
        $this->expectException(DivisionByZeroException::class);

        // Act
        $a->pow(-1);
    }

    public function testThrowsOnZeroToNegativeRealExponent(): void
    {
        // Arrange
        $a = Complex::zero();
        $this->expectException(DivisionByZeroException::class);

        // Act
        $a->pow(-0.5);
    }

    public function testThrowsOnNonFiniteExponent(): void
    {
        // Arrange
        $a = Complex::one();
        $this->expectException(InvalidValueException::class);

        // Act
        $a->pow(NAN);
    }

    public function testThrowsOnMinimumIntegerExponent(): void
    {
        // Arrange
        $a = Complex::one();
        $this->expectException(InvalidValueException::class);

        // Act
        $a->pow(PHP_INT_MIN);
    }

    public function testZeroToANegativeIntegerPowerThrowsThePowerMessage(): void
    {
        // Arrange
        $a = Complex::zero();

        // Assert
        $this->expectException(DivisionByZeroException::class);
        $this->expectExceptionMessage('Cannot raise zero to a negative power.');

        // Act
        $a->pow(-2);
    }
}
