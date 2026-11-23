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
#[CoversMethod(Complex::class, 'conjugate')]
final class ConjugateTest extends TestCase
{
    public function testFlipsImaginarySign(): void
    {
        // Arrange
        $a = Complex::of(3.0, 4.0);

        // Act
        $result = $a->conjugate();

        // Assert
        self::assertEqualsWithDelta(3.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(-4.0, $result->imaginary(), 1.0E-12);
    }

    public function testProductWithConjugateIsSquaredModulus(): void
    {
        // Arrange
        $a = Complex::of(3.0, 4.0);

        // Act
        $result = $a->multiply($a->conjugate());

        // Assert
        self::assertEqualsWithDelta(25.0, $result->real(), 1.0E-12);
    }
}
