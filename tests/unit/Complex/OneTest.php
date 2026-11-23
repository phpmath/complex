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
#[CoversMethod(Complex::class, 'one')]
final class OneTest extends TestCase
{
    public function testReturnsOne(): void
    {
        // Act
        $result = Complex::one();

        // Assert
        self::assertSame(1.0, $result->real());
        self::assertSame(0.0, $result->imaginary());
    }
}
