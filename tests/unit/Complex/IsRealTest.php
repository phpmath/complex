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
#[CoversMethod(Complex::class, 'isReal')]
final class IsRealTest extends TestCase
{
    public function testIsRealForTheMatchingNumber(): void
    {
        // Arrange
        $a = Complex::of(3.0, 0.0);

        // Act
        $result = $a->isReal();

        // Assert
        self::assertTrue($result);
    }

    public function testIsRealIsFalseForOtherNumbers(): void
    {
        // Arrange
        $a = Complex::of(3.0, 1.0);

        // Act
        $result = $a->isReal();

        // Assert
        self::assertFalse($result);
    }

    public function testZeroIsReal(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->isReal();

        // Assert
        self::assertTrue($result);
    }
}
