<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Tests\Complex;

use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\DivisionByZeroException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'reciprocal')]
final class ReciprocalTest extends TestCase
{
    public function testReturnsReciprocal(): void
    {
        // Arrange
        $a = Complex::of(0.0, 2.0);

        // Act
        $result = $a->reciprocal();

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(-0.5, $result->imaginary(), 1.0E-12);
    }

    public function testThrowsOnZero(): void
    {
        // Arrange
        $a = Complex::zero();
        $this->expectException(DivisionByZeroException::class);

        // Act
        $a->reciprocal();
    }
}
