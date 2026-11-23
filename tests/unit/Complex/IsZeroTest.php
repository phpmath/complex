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
#[CoversMethod(Complex::class, 'isZero')]
final class IsZeroTest extends TestCase
{
    public function testIsZeroForTheMatchingNumber(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->isZero();

        // Assert
        self::assertTrue($result);
    }

    public function testIsZeroIsFalseForOtherNumbers(): void
    {
        // Arrange
        $a = Complex::of(0.0, 1.0);

        // Act
        $result = $a->isZero();

        // Assert
        self::assertFalse($result);
    }

    public function testNegativeZeroCountsAsZero(): void
    {
        // Arrange
        $a = Complex::of(-0.0, -0.0);

        // Act
        $result = $a->isZero();

        // Assert
        self::assertTrue($result);
    }
}
