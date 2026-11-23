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

use const PHP_FLOAT_MAX;

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'isFinite')]
final class IsFiniteTest extends TestCase
{
    public function testFiniteNumberIsFinite(): void
    {
        // Arrange
        $a = Complex::of(1.0, 2.0);

        // Act
        $result = $a->isFinite();

        // Assert
        self::assertTrue($result);
    }

    public function testOverflowedRealPartIsNotFinite(): void
    {
        // Arrange
        $a = Complex::of(PHP_FLOAT_MAX, 0.0)->add(Complex::of(PHP_FLOAT_MAX, 0.0));

        // Act
        $result = $a->isFinite();

        // Assert
        self::assertFalse($result);
    }

    public function testOverflowedImaginaryPartIsNotFinite(): void
    {
        // Arrange
        $a = Complex::of(0.0, PHP_FLOAT_MAX)->add(Complex::of(0.0, PHP_FLOAT_MAX));

        // Act
        $result = $a->isFinite();

        // Assert
        self::assertFalse($result);
    }
}
