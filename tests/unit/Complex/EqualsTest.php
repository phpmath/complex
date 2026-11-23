<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Tests\Complex;

use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\InvalidValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

use const INF;
use const NAN;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'equals')]
final class EqualsTest extends TestCase
{
    public function testEqualNumbersAreEqual(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->equals(Complex::of(1.0, 2.0));

        // Assert
        self::assertTrue($result);
    }

    public function testDifferenceWithinToleranceIsEqual(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->equals(Complex::of(1.0 + 1.0E-10, 2.0 - 1.0E-10));

        // Assert
        self::assertTrue($result);
    }

    public function testDifferenceBeyondDefaultToleranceIsNotEqual(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->equals(Complex::of(1.001, 2.0));

        // Assert
        self::assertFalse($result);
    }

    public function testDifferentImaginaryPartIsNotEqual(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->equals(Complex::of(1.0, 2.5));

        // Assert
        self::assertFalse($result);
    }

    public function testCustomToleranceIsUsed(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->equals(Complex::of(1.001, 2.0), 0.01);

        // Assert
        self::assertTrue($result);
    }

    public function testZeroToleranceRequiresExactMatch(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->equals(Complex::of(1.0 + 1.0E-12, 2.0), 0.0);

        // Assert
        self::assertFalse($result);
    }

    public function testThrowsOnNegativeTolerance(): void
    {
        // Arrange
        $a = Complex::one();
        $this->expectException(InvalidValueException::class);

        // Act
        $a->equals(Complex::one(), -0.1);
    }

    public function testThrowsOnNanTolerance(): void
    {
        // Arrange
        $a = Complex::one();
        $this->expectException(InvalidValueException::class);

        // Act
        $a->equals(Complex::one(), NAN);
    }

    public function testRejectsInfiniteTolerance(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Assert
        $this->expectException(InvalidValueException::class);

        // Act
        $a->equals(Complex::of(100.0, -50.0), INF);
    }
}
