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
#[CoversMethod(Complex::class, 'add')]
final class AddTest extends TestCase
{
    public function testAddsParts(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);
        $b = Complex::of(3.0, -5.0);

        // Act
        $result = $a->add($b);

        // Assert
        self::assertEqualsWithDelta(4.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(-3.0, $result->imaginary(), 1.0E-12);
    }

    public function testReturnsNewInstance(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->add(Complex::zero());

        // Assert
        self::assertNotSame($a, $result);
        self::assertSame(1.0, $a->real());
    }
}
