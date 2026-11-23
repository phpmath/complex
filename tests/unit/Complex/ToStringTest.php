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

use function ini_get;
use function ini_set;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, '__toString')]
final class ToStringTest extends TestCase
{
    public function testFormatsPositiveImaginaryPart(): void
    {
        // Arrange
        $a = Complex::of(3.0, 4.0);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('3+4i', $result);
    }

    public function testFormatsNegativeImaginaryPart(): void
    {
        // Arrange
        $a = Complex::of(3.0, -4.0);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('3-4i', $result);
    }

    public function testFormatsFractions(): void
    {
        // Arrange
        $a = Complex::of(1.5, -2.5);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('1.5-2.5i', $result);
    }

    public function testFormatsNegativeRealPart(): void
    {
        // Arrange
        $a = Complex::of(-3.0, 4.0);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('-3+4i', $result);
    }

    public function testFormatsZero(): void
    {
        // Arrange
        $a = Complex::of(0.0, 0.0);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('0+0i', $result);
    }

    public function testFormatsNegativeZeroAsZero(): void
    {
        // Arrange
        $a = Complex::of(-0.0, -0.0);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('0+0i', $result);
    }

    public function testKeepsTinyValuesWithoutExponent(): void
    {
        // Arrange
        $a = Complex::of(1.0E-7, -1.0E-7);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('0.0000001-0.0000001i', $result);
    }

    public function testRoundsFloatingPointNoise(): void
    {
        // Arrange
        $a = Complex::of(0.1 + 0.2, 0.1 + 0.2);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('0.3+0.3i', $result);
    }

    public function testFormatsLargeValuesWithoutExponent(): void
    {
        // Arrange
        $a = Complex::of(1.0E+20, 0.0);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('100000000000000000000+0i', $result);
    }

    public function testPrintsValuesBelowTheDecimalLimitAsZero(): void
    {
        // Arrange
        $a = Complex::of(-1.0E-20, -1.0E-20);

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('0+0i', $result);
    }

    public function testFormatsInfiniteParts(): void
    {
        // Arrange
        $a = Complex::of(1.0E+200, 0.0)->multiply(Complex::of(1.0E+200, 0.0));

        // Act
        $result = (string) $a;

        // Assert
        self::assertSame('INF+0i', $result);
    }

    public function testIgnoresThePrecisionIniSetting(): void
    {
        // Arrange
        $a = Complex::of(1.0 / 3.0, -2.0 / 3.0);
        $previous = ini_get('precision');

        // Act
        try {
            ini_set('precision', '3');
            $result = (string) $a;
        } finally {
            ini_set('precision', $previous);
        }

        // Assert
        self::assertSame('0.33333333333333-0.66666666666667i', $result);
    }

    public function testPrintsNotANumberWithoutAWarning(): void
    {
        // Arrange
        $number = Complex::of(1000.0)->exp();

        // Act
        $result = (string) $number;

        // Assert
        self::assertSame('INF+NANi', $result);
    }
}
