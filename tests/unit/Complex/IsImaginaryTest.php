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
#[CoversMethod(Complex::class, 'isImaginary')]
final class IsImaginaryTest extends TestCase
{
    public function testIsImaginaryForTheMatchingNumber(): void
    {
        // Arrange
        $a = Complex::of(0.0, 3.0);

        // Act
        $result = $a->isImaginary();

        // Assert
        self::assertTrue($result);
    }

    public function testIsImaginaryIsFalseForOtherNumbers(): void
    {
        // Arrange
        $a = Complex::of(1.0, 3.0);

        // Act
        $result = $a->isImaginary();

        // Assert
        self::assertFalse($result);
    }

    public function testZeroIsImaginary(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->isImaginary();

        // Assert
        self::assertTrue($result);
    }
}
