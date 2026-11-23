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
#[CoversMethod(Complex::class, 'scale')]
final class ScaleTest extends TestCase
{
    public function testScalesBothParts(): void
    {
        // Arrange
        $a = Complex::of(1.0, -2.0);

        // Act
        $result = $a->scale(3.0);

        // Assert
        self::assertSame(3.0, $result->real());
        self::assertSame(-6.0, $result->imaginary());
    }

    public function testReturnsNewInstance(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->scale(2.0);

        // Assert
        self::assertNotSame($a, $result);
        self::assertSame(1.0, $a->real());
    }

    public function testNegativeFactorFlipsBothParts(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->scale(-1.0);

        // Assert
        self::assertSame(-1.0, $result->real());
        self::assertSame(-2.0, $result->imaginary());
    }

    public function testRejectsInfiniteFactor(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        $this->expectException(InvalidValueException::class);

        // Act
        $a->scale(INF);
    }

    public function testRejectsNanFactor(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        $this->expectException(InvalidValueException::class);

        // Act
        $a->scale(NAN);
    }
}
