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
#[CoversMethod(Complex::class, 'of')]
final class OfTest extends TestCase
{
    public function testStoresParts(): void
    {
        // Act
        $result = Complex::of(3.0, 4.0);

        // Assert
        self::assertSame(3.0, $result->real());
        self::assertSame(4.0, $result->imaginary());
    }

    public function testImaginaryPartDefaultsToZero(): void
    {
        // Act
        $result = Complex::of(2.5);

        // Assert
        self::assertSame(0.0, $result->imaginary());
    }

    public function testThrowsOnNanRealPart(): void
    {
        // Arrange
        $this->expectException(InvalidValueException::class);

        // Act
        Complex::of(NAN, 0.0);
    }

    public function testThrowsOnInfiniteImaginaryPart(): void
    {
        // Arrange
        $this->expectException(InvalidValueException::class);

        // Act
        Complex::of(0.0, INF);
    }
}
