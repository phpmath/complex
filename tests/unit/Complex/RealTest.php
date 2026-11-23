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
#[CoversMethod(Complex::class, 'real')]
final class RealTest extends TestCase
{
    public function testReturnsRealPart(): void
    {
        // Arrange
        $number = Complex::of(3.0, 4.0);

        // Act
        $result = $number->real();

        // Assert
        self::assertSame(3.0, $result);
    }
}
