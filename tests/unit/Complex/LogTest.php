<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex\Tests\Complex;

use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\UndefinedResultException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

use const M_PI;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'log')]
final class LogTest extends TestCase
{
    public function testLogarithmOfOneIsZero(): void
    {
        // Arrange
        $a = Complex::one();

        // Act
        $result = $a->log();

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(0.0, $result->imaginary(), 1.0E-12);
    }

    public function testLogarithmOfMinusOne(): void
    {
        // Arrange
        $a = Complex::of(-1.0, 0.0);

        // Act
        $result = $a->log();

        // Assert
        self::assertEqualsWithDelta(0.0, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(M_PI, $result->imaginary(), 1.0E-12);
    }

    public function testLogarithmUndoesExponential(): void
    {
        // Arrange
        $a = Complex::of(0.5, 1.0);

        // Act
        $result = $a->exp()->log();

        // Assert
        self::assertEqualsWithDelta(0.5, $result->real(), 1.0E-12);
        self::assertEqualsWithDelta(1.0, $result->imaginary(), 1.0E-12);
    }

    public function testThrowsOnZero(): void
    {
        // Arrange
        $a = Complex::zero();
        $this->expectException(UndefinedResultException::class);

        // Act
        $a->log();
    }
}
