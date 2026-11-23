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

use const M_E;
use const M_PI;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'exp')]
final class ExpTest extends TestCase
{
    public function testExponentialOfZeroIsOne(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->exp();

        // Assert
        self::assertEqualsWithDelta(1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testEulersIdentity(): void
    {
        // Arrange
        $a = Complex::of(0.0, M_PI);

        // Act
        $result = $a->exp();

        // Assert
        self::assertEqualsWithDelta(-1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testExponentialOfRealNumber(): void
    {
        // Arrange
        $a = Complex::of(1.0, 0.0);

        // Act
        $result = $a->exp();

        // Assert
        self::assertEqualsWithDelta(M_E, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }
}
