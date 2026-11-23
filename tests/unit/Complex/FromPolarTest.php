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
use const M_PI;
use const NAN;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'fromPolar')]
final class FromPolarTest extends TestCase
{
    public function testConvertsToCartesian(): void
    {
        // Act
        $result = Complex::fromPolar(2.0, M_PI / 2);

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(2.0, $result->imaginary(), 1.0E-12);
    }

    public function testZeroModulusGivesZero(): void
    {
        // Act
        $result = Complex::fromPolar(0.0, 1.0);

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testThrowsOnNegativeModulus(): void
    {
        // Arrange
        $this->expectException(InvalidValueException::class);

        // Act
        Complex::fromPolar(-1.0, 0.0);
    }

    public function testThrowsOnNonFiniteArgument(): void
    {
        // Arrange
        $this->expectException(InvalidValueException::class);

        // Act
        Complex::fromPolar(1.0, INF);
    }

    public function testThrowsOnNonFiniteModulus(): void
    {
        // Arrange
        $this->expectException(InvalidValueException::class);

        // Act
        Complex::fromPolar(NAN, 0.0);
    }
}
