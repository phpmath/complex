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

use const M_PI;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'argument')]
final class ArgumentTest extends TestCase
{
    public function testReturnsAngleOfImaginaryUnit(): void
    {
        // Arrange
        $number = Complex::i();

        // Act
        $result = $number->argument();

        // Assert
        self::assertEqualsWithDelta(M_PI / 2, $result, 1.0E-12);
    }

    public function testNegativeRealAxisHasArgumentPi(): void
    {
        // Arrange
        $number = Complex::of(-1.0, 0.0);

        // Act
        $result = $number->argument();

        // Assert
        self::assertEqualsWithDelta(M_PI, $result, 1.0E-12);
    }

    public function testThirdQuadrantIsNegative(): void
    {
        // Arrange
        $number = Complex::of(-1.0, -1.0);

        // Act
        $result = $number->argument();

        // Assert
        self::assertEqualsWithDelta(-3 * M_PI / 4, $result, 1.0E-12);
    }

    public function testNegativeRealNumberWithNegativeZeroImaginaryPartHasArgumentPi(): void
    {
        // Arrange
        $a = Complex::of(-1.0, -0.0);

        // Act
        $result = $a->argument();

        // Assert
        self::assertEqualsWithDelta(M_PI, $result, 1.0E-12);
    }
}
