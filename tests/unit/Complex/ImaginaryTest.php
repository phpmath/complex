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
#[CoversMethod(Complex::class, 'imaginary')]
final class ImaginaryTest extends TestCase
{
    public function testReturnsImaginaryPart(): void
    {
        // Arrange
        $number = Complex::of(3.0, 4.0);

        // Act
        $result = $number->imaginary();

        // Assert
        self::assertSame(4.0, $result);
    }
}
