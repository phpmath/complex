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
#[CoversMethod(Complex::class, 'negate')]
final class NegateTest extends TestCase
{
    public function testNegatesBothParts(): void
    {
        // Arrange
        $a = Complex::of(1.0, -2.0);

        // Act
        $result = $a->negate();

        // Assert
        self::assertEqualsWithDelta(-1.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(2.0, $result->imaginary(), 1.0E-12);
    }

    public function testNegatingTwiceRestoresNumber(): void
    {
        // Arrange
        $a = Complex::of(1.0, -2.0);

        // Act
        $result = $a->negate()->negate();

        // Assert
        self::assertTrue($result->equals($a));
    }
}
