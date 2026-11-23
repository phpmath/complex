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

use function sqrt;

use const M_SQRT2;
use const PHP_FLOAT_MAX;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'sqrt')]
final class SqrtTest extends TestCase
{
    public function testRootOfNegativeRealIsImaginary(): void
    {
        // Arrange
        $a = Complex::of(-4.0, 0.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(2.0, $result->imaginary(), 1.0E-12);
    }

    public function testRootOfComplexNumber(): void
    {
        // Arrange
        $a = Complex::of(3.0, 4.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertEqualsWithDelta(2.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(1.0, $result->imaginary(), 1.0E-12);
    }

    public function testRootOfNegativeImaginaryPartHasNegativeImaginaryPart(): void
    {
        // Arrange
        $a = Complex::of(3.0, -4.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertEqualsWithDelta(2.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(-1.0, $result->imaginary(), 1.0E-12);
    }

    public function testRootOfZeroIsZero(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testSmallImaginaryPartKeepsItsPrecisionNextToALargeRealPart(): void
    {
        // Arrange
        $a = Complex::of(1.0, 1.0E-20);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertSame(1.0, $result->real());
        self::assertEqualsWithDelta(5.0E-21, $result->imaginary(), 1.0E-35);
    }

    public function testSmallImaginaryPartKeepsItsPrecisionNextToANegativeRealPart(): void
    {
        // Arrange
        $a = Complex::of(-1.0, -1.0E-20);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertEqualsWithDelta(5.0E-21, $result->real(), 1.0E-35);
        self::assertSame(-1.0, $result->imaginary());
    }

    public function testLargestRealNumberDoesNotOverflow(): void
    {
        // Arrange
        $a = Complex::of(PHP_FLOAT_MAX, 0.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertEqualsWithDelta(1.3407807929942596E154, $result->real(), 1.0E140);
        self::assertSame(0.0, $result->imaginary());
    }

    public function testLargestMixedNumberDoesNotOverflow(): void
    {
        // Arrange
        $a = Complex::of(PHP_FLOAT_MAX, PHP_FLOAT_MAX);

        // Act
        $result = $a->sqrt();

        // Assert
        $root = sqrt(PHP_FLOAT_MAX);
        self::assertTrue($result->isFinite());
        self::assertEqualsWithDelta($root * sqrt((M_SQRT2 + 1.0) / 2.0), $result->real(), 1.0E-12 * $root);
        self::assertEqualsWithDelta($root * sqrt((M_SQRT2 - 1.0) / 2.0), $result->imaginary(), 1.0E-12 * $root);
    }

    public function testLargestNegativeRealNumberDoesNotOverflow(): void
    {
        // Arrange
        $a = Complex::of(-PHP_FLOAT_MAX, 0.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertSame(0.0, $result->real());
        self::assertEqualsWithDelta(1.3407807929942596E154, $result->imaginary(), 1.0E140);
    }

    public function testSubnormalNumberHasAFiniteRoot(): void
    {
        // Arrange
        $a = Complex::of(4.9E-324, 0.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertTrue($result->isFinite());
        self::assertEqualsWithDelta(2.2E-162, $result->real(), 1.0E-163);
    }

    public function testZeroHasZeroAsRoot(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertTrue($result->isZero());
    }

    public function testRootSquaredGivesTheOriginalNumber(): void
    {
        // Arrange
        $a = Complex::of(-3.0, 4.0);

        // Act
        $result = $a->sqrt()->multiply($a->sqrt());

        // Assert
        self::assertTrue($result->equals($a));
    }

    public function testRootHasAlwaysANonNegativeRealPart(): void
    {
        // Arrange
        $a = Complex::of(-3.0, -4.0);

        // Act
        $result = $a->sqrt();

        // Assert
        self::assertGreaterThanOrEqual(0.0, $result->real());
        self::assertEqualsWithDelta(-2.0, $result->imaginary(), 1.0E-12);
    }
}
