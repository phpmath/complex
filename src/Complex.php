<?php

/**
 * phpmath / complex (https://github.com/phpmath/complex)
 *
 * @link https://github.com/phpmath/complex for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\Complex;

use PHPMath\Complex\Exception\DivisionByZeroException;
use PHPMath\Complex\Exception\InvalidValueException;
use PHPMath\Complex\Exception\UndefinedResultException;
use Stringable;

use function abs;
use function atan2;
use function cos;
use function exp;
use function hypot;
use function is_finite;
use function is_float;
use function is_nan;
use function log;
use function number_format;
use function pow;
use function rtrim;
use function sin;
use function sqrt;
use function str_starts_with;

use const M_PI;
use const PHP_INT_MIN;

/**
 * An immutable complex number with a float real and a float imaginary part.
 *
 * Every operation returns a new instance. Input given to the named constructors must be finite. Results of
 * operations, including fromPolar() and roots(), are not checked, so an overflow yields INF or NAN just like plain
 * float arithmetic does. Use isFinite() to detect that.
 */
final readonly class Complex implements Stringable
{
    /** Parts above this value are scaled down before a square root, so that the intermediate sums cannot overflow. */
    private const float SQRT_SCALE_LIMIT = 1.0E300;

    private function __construct(
        private float $real,
        private float $imaginary,
    ) {
    }

    /** @throws InvalidValueException When a part is NAN or infinite. */
    public static function of(float $real, float $imaginary = 0.0): self
    {
        if (! is_finite($real) || ! is_finite($imaginary)) {
            throw new InvalidValueException('The real and imaginary part must be finite.');
        }

        return new self($real, $imaginary);
    }

    /** @throws InvalidValueException When an argument is not finite or the modulus is negative. */
    public static function fromPolar(float $modulus, float $argument): self
    {
        if (! is_finite($modulus) || ! is_finite($argument)) {
            throw new InvalidValueException('The modulus and argument must be finite.');
        }

        if ($modulus < 0.0) {
            throw new InvalidValueException('The modulus must not be negative.');
        }

        return new self($modulus * cos($argument), $modulus * sin($argument));
    }

    public static function zero(): self
    {
        return new self(0.0, 0.0);
    }

    public static function one(): self
    {
        return new self(1.0, 0.0);
    }

    /**
     * The imaginary unit.
     */
    public static function i(): self
    {
        return new self(0.0, 1.0);
    }

    public function real(): float
    {
        return $this->real;
    }

    public function imaginary(): float
    {
        return $this->imaginary;
    }

    public function modulus(): float
    {
        return hypot($this->real, $this->imaginary);
    }

    /**
     * The principal argument, in the range from -pi (exclusive) to pi (inclusive).
     */
    public function argument(): float
    {
        // Adding zero turns a negative zero into a positive zero, so that -1-0i has the argument pi, not -pi.
        return atan2($this->imaginary + 0.0, $this->real);
    }

    public function add(self $other): self
    {
        return new self($this->real + $other->real, $this->imaginary + $other->imaginary);
    }

    public function subtract(self $other): self
    {
        return new self($this->real - $other->real, $this->imaginary - $other->imaginary);
    }

    public function multiply(self $other): self
    {
        return new self(
            $this->real * $other->real - $this->imaginary * $other->imaginary,
            $this->real * $other->imaginary + $this->imaginary * $other->real,
        );
    }

    /** @throws DivisionByZeroException When the divisor is zero. */
    public function divide(self $other): self
    {
        if ($other->isZero()) {
            throw new DivisionByZeroException('Cannot divide by zero.');
        }

        // Smith's algorithm, which avoids needless overflow of the intermediate results.
        if (abs($other->real) >= abs($other->imaginary)) {
            $ratio = $other->imaginary / $other->real;
            $denominator = $other->real + $other->imaginary * $ratio;

            return new self(
                ($this->real + $this->imaginary * $ratio) / $denominator,
                ($this->imaginary - $this->real * $ratio) / $denominator,
            );
        }

        $ratio = $other->real / $other->imaginary;
        $denominator = $other->real * $ratio + $other->imaginary;

        return new self(
            ($this->real * $ratio + $this->imaginary) / $denominator,
            ($this->imaginary * $ratio - $this->real) / $denominator,
        );
    }

    public function negate(): self
    {
        return new self(-$this->real, -$this->imaginary);
    }

    public function conjugate(): self
    {
        return new self($this->real, -$this->imaginary);
    }

    /** @throws DivisionByZeroException When this number is zero. */
    public function reciprocal(): self
    {
        return self::one()->divide($this);
    }

    /**
     * Raises this number to a power.
     *
     * An integer exponent uses repeated multiplication and is exact for exact input. A float exponent uses the
     * principal value, exp(exponent * log(this)). Zero to the power zero is one.
     *
     * @throws DivisionByZeroException When this number is zero and the exponent is negative.
     * @throws InvalidValueException When the exponent is not finite or is PHP_INT_MIN.
     */
    public function pow(int|float $exponent): self
    {
        if (is_float($exponent)) {
            return $this->powFloat($exponent);
        }

        if ($exponent === PHP_INT_MIN) {
            throw new InvalidValueException('The exponent is out of range.');
        }

        if ($exponent < 0 && $this->isZero()) {
            throw new DivisionByZeroException('Cannot raise zero to a negative power.');
        }

        $result = self::one();
        $base = $this;

        for ($remaining = $exponent < 0 ? -$exponent : $exponent; $remaining > 0; $remaining >>= 1) {
            if (($remaining & 1) === 1) {
                $result = $result->multiply($base);
            }

            if ($remaining <= 1) {
                continue;
            }

            $base = $base->multiply($base);
        }

        return $exponent < 0 ? $result->reciprocal() : $result;
    }

    /**
     * The principal square root, which has a non-negative real part.
     *
     * The larger part of the result is computed first and the smaller part is derived from it, so the smaller part
     * keeps its precision when the two parts differ a lot. Very large input is scaled down first, so the result is
     * finite whenever it fits in a float.
     */
    public function sqrt(): self
    {
        if ($this->isZero()) {
            return self::zero();
        }

        $real = abs($this->real);
        $imaginary = abs($this->imaginary);
        $scaled = $real > self::SQRT_SCALE_LIMIT || $imaginary > self::SQRT_SCALE_LIMIT;

        if ($scaled) {
            // Dividing by four is exact and halves the exponent of the result, which is restored at the end.
            $real /= 4.0;
            $imaginary /= 4.0;
        }

        $larger = sqrt(($real + hypot($real, $imaginary)) / 2.0);
        $smaller = $imaginary / (2.0 * $larger);

        if ($scaled) {
            $larger *= 2.0;
            $smaller *= 2.0;
        }

        $negativeImaginary = $this->imaginary < 0.0;

        if ($this->real >= 0.0) {
            return new self($larger, $negativeImaginary ? -$smaller : $smaller);
        }

        return new self($smaller, $negativeImaginary ? -$larger : $larger);
    }

    public function exp(): self
    {
        $scale = exp($this->real);

        return new self($scale * cos($this->imaginary), $scale * sin($this->imaginary));
    }

    /**
     * The principal natural logarithm.
     *
     * @throws UndefinedResultException When this number is zero.
     */
    public function log(): self
    {
        if ($this->isZero()) {
            throw new UndefinedResultException('The logarithm of zero is undefined.');
        }

        return new self(log($this->modulus()), $this->argument());
    }

    /**
     * All n-th roots, starting with the principal root and going counterclockwise.
     *
     * The result holds one number per root, so memory use grows with n.
     *
     * @return list<self>
     *
     * @throws InvalidValueException When n is smaller than one.
     */
    public function roots(int $n): array
    {
        if ($n < 1) {
            throw new InvalidValueException('The degree of the roots must be at least one.');
        }

        $modulus = pow($this->modulus(), 1.0 / $n);
        $argument = $this->argument();
        $roots = [];

        for ($k = 0; $k < $n; ++$k) {
            $angle = ($argument + 2.0 * M_PI * $k) / $n;
            $roots[] = new self($modulus * cos($angle), $modulus * sin($angle));
        }

        return $roots;
    }

    /**
     * Whether both parts are zero. Negative zero counts as zero.
     */
    public function isZero(): bool
    {
        return $this->real === 0.0 && $this->imaginary === 0.0;
    }

    /**
     * Whether the imaginary part is zero, so the number lies on the real axis.
     */
    public function isReal(): bool
    {
        return $this->imaginary === 0.0;
    }

    /**
     * Whether the real part is zero, so the number lies on the imaginary axis. Zero is both real and imaginary.
     */
    public function isImaginary(): bool
    {
        return $this->real === 0.0;
    }

    /**
     * Whether both parts are finite. Results of operations can overflow to INF or NAN, this tells you.
     */
    public function isFinite(): bool
    {
        return is_finite($this->real) && is_finite($this->imaginary);
    }

    /**
     * Multiplies both parts by a real factor.
     *
     * @throws InvalidValueException When the factor is NAN or infinite.
     */
    public function scale(float $factor): self
    {
        if (! is_finite($factor)) {
            throw new InvalidValueException('The factor must be finite.');
        }

        return new self($this->real * $factor, $this->imaginary * $factor);
    }

    /**
     * Whether both parts differ by at most the given absolute tolerance.
     *
     * @throws InvalidValueException When the tolerance is negative, NAN or infinite.
     */
    public function equals(self $other, float $tolerance = 1e-9): bool
    {
        if (! is_finite($tolerance) || $tolerance < 0.0) {
            throw new InvalidValueException('The tolerance must be finite and not negative.');
        }

        return abs($this->real - $other->real) <= $tolerance
            && abs($this->imaginary - $other->imaginary) <= $tolerance;
    }

    /**
     * Formats the number as "a+bi" or "a-bi".
     *
     * Each part is a plain decimal with at most 14 decimals, no exponent, no trailing zeros and
     * never a negative zero. The result does not depend on the "precision" ini setting.
     */
    public function __toString(): string
    {
        $real = self::formatNumber($this->real);
        $imaginary = self::formatNumber($this->imaginary);

        if (str_starts_with($imaginary, '-')) {
            return $real . $imaginary . 'i';
        }

        return $real . '+' . $imaginary . 'i';
    }

    private static function formatNumber(float $value): string
    {
        if (! is_finite($value)) {
            return is_nan($value) ? 'NAN' : ($value > 0.0 ? 'INF' : '-INF');
        }

        $text = number_format($value, 14, '.', '');
        $text = rtrim(rtrim($text, '0'), '.');

        return $text === '-0' ? '0' : $text;
    }

    private function powFloat(float $exponent): self
    {
        if (! is_finite($exponent)) {
            throw new InvalidValueException('The exponent must be finite.');
        }

        if ($exponent === 0.0) {
            return self::one();
        }

        if ($this->isZero()) {
            if ($exponent < 0.0) {
                throw new DivisionByZeroException('Cannot raise zero to a negative power.');
            }

            return self::zero();
        }

        $modulus = pow($this->modulus(), $exponent);
        $argument = $this->argument() * $exponent;

        return new self($modulus * cos($argument), $modulus * sin($argument));
    }
}
