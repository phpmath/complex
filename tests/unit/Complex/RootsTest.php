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

#[CoversClass(Complex::class)]
#[CoversMethod(Complex::class, 'roots')]
final class RootsTest extends TestCase
{
    public function testReturnsRequestedCount(): void
    {
        // Arrange
        $a = Complex::of(16.0, 0.0);

        // Act
        $result = $a->roots(4);

        // Assert
        self::assertCount(4, $result);
    }

    public function testRootsOfUnityAreAllRaisedBackToOne(): void
    {
        // Arrange
        $a = Complex::one();

        // Act
        $result = $a->roots(5);

        // Assert
        foreach ($result as $root) {
            self::assertTrue($root->pow(5)->equals(Complex::one()));
        }
    }

    public function testFirstRootIsPrincipalRoot(): void
    {
        // Arrange
        $a = Complex::of(-4.0, 0.0);

        // Act
        $result = $a->roots(2);

        // Assert
        self::assertTrue($result[0]->equals(Complex::of(0.0, 2.0)));
        self::assertTrue($result[1]->equals(Complex::of(0.0, -2.0)));
    }

    public function testRootsOfZeroAreAllZero(): void
    {
        // Arrange
        $a = Complex::zero();

        // Act
        $result = $a->roots(3);

        // Assert
        self::assertCount(3, $result);
        self::assertTrue($result[2]->equals(Complex::zero()));
    }

    public function testFirstRootOfOneIsOne(): void
    {
        // Arrange
        $a = Complex::one();

        // Act
        $result = $a->roots(1);

        // Assert
        self::assertCount(1, $result);
        self::assertTrue($result[0]->equals($a));
    }

    public function testThrowsOnZeroDegree(): void
    {
        // Arrange
        $a = Complex::one();
        $this->expectException(InvalidValueException::class);

        // Act
        $a->roots(0);
    }

    public function testThrowsOnNegativeDegree(): void
    {
        // Arrange
        $a = Complex::one();
        $this->expectException(InvalidValueException::class);

        // Act
        $a->roots(-2);
    }
}
