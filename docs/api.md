---
title: API reference
intro: Every public method of Complex, grouped by purpose.
group: Reference
order: 80
layout: reference
---

Every method returns a new `Complex` unless the return type says otherwise. All methods belong to `PHPMath\Complex\Complex`, a `final readonly` class that implements `Stringable`. The class has no public constructor.

## Construction

Create a number from its parts, from polar form or from one of the constants.

### of()

```php
public static function of(float $real, float $imaginary = 0.0): self
```

Creates a number from a real and an imaginary part.

- **Parameters:** `$real` the real part, `$imaginary` the imaginary part
- **Returns:** `Complex`
- **Throws:** [InvalidValueException](errors.md) if a part is `NAN` or infinite

### fromPolar()

```php
public static function fromPolar(float $modulus, float $argument): self
```

Creates a number from its distance to the origin and its angle in radians.

- **Parameters:** `$modulus` the distance, `$argument` the angle in radians
- **Returns:** `Complex`
- **Throws:** [InvalidValueException](errors.md) if an argument is `NAN` or infinite, or the modulus is negative

### zero()

```php
public static function zero(): self
```

Returns the number `0+0i`.

- **Returns:** `Complex`

### one()

```php
public static function one(): self
```

Returns the number `1+0i`.

- **Returns:** `Complex`

### i()

```php
public static function i(): self
```

Returns the imaginary unit `0+1i`.

- **Returns:** `Complex`

## Reading values

Read the parts of a number, or its polar form.

### real()

```php
public function real(): float
```

Returns the real part.

- **Returns:** `float`

### imaginary()

```php
public function imaginary(): float
```

Returns the imaginary part.

- **Returns:** `float`

### modulus()

```php
public function modulus(): float
```

Returns the distance to the origin. The result is `INF` only when it does not fit in a float.

- **Returns:** `float`

### argument()

```php
public function argument(): float
```

Returns the principal argument in radians, in the range from -pi (exclusive) to pi (inclusive). Zero has the argument 0. A negative zero in the imaginary part counts as a positive zero, so a number on the negative real axis always gives pi.

- **Returns:** `float`

## Arithmetic

Add, subtract, multiply and divide, and the related operations.

### add()

```php
public function add(self $other): self
```

Adds a number.

- **Parameters:** `$other` the other operand
- **Returns:** `Complex`

### subtract()

```php
public function subtract(self $other): self
```

Subtracts a number.

- **Parameters:** `$other` the other operand
- **Returns:** `Complex`

### multiply()

```php
public function multiply(self $other): self
```

Multiplies by a number.

- **Parameters:** `$other` the other operand
- **Returns:** `Complex`

### divide()

```php
public function divide(self $other): self
```

Divides by a number, using Smith's algorithm.

- **Parameters:** `$other` the divisor
- **Returns:** `Complex`
- **Throws:** [DivisionByZeroException](errors.md) if the divisor is zero

### negate()

```php
public function negate(): self
```

Flips the sign of both parts.

- **Returns:** `Complex`

### conjugate()

```php
public function conjugate(): self
```

Flips the sign of the imaginary part.

- **Returns:** `Complex`

### reciprocal()

```php
public function reciprocal(): self
```

Returns `1/z`.

- **Returns:** `Complex`
- **Throws:** [DivisionByZeroException](errors.md) if this number is zero

## Powers and roots

Powers, the principal square root and all n-th roots.

### pow()

```php
public function pow(int|float $exponent): self
```

Raises this number to a power. An int exponent uses repeated multiplication. A float exponent uses the principal value `exp(exponent * log(z))`. Zero to the power zero is one.

- **Parameters:** `$exponent` the power
- **Returns:** `Complex`
- **Throws:** [DivisionByZeroException](errors.md) if this number is zero and the exponent is negative
- **Throws:** [InvalidValueException](errors.md) if the exponent is a float that is `NAN` or infinite, or is `PHP_INT_MIN`

### sqrt()

```php
public function sqrt(): self
```

Returns the principal square root, which has a real part that is not negative. The smaller part of the result keeps its precision even when the two parts differ a lot, and very large numbers do not overflow as long as the root fits in a float.

- **Returns:** `Complex`

### scale()

```php
public function scale(float $factor): self
```

Multiplies both parts by a real factor.

- **Parameters:** `$factor` the factor, which must be finite
- **Returns:** `Complex`
- **Throws:** [InvalidValueException](errors.md) if the factor is `NAN` or infinite

### roots()

```php
public function roots(int $n): array
```

Returns all n-th roots, starting with the principal root and going counterclockwise. The list holds one `Complex` per root.

- **Parameters:** `$n` the degree, at least 1
- **Returns:** `list<Complex>` with exactly `$n` items
- **Throws:** [InvalidValueException](errors.md) if `$n` is smaller than 1

## Exponential and logarithm

The exponential function and its inverse.

### exp()

```php
public function exp(): self
```

Returns e raised to this number. A large real part gives `INF` or `NAN` parts.

- **Returns:** `Complex`

### log()

```php
public function log(): self
```

Returns the principal natural logarithm.

- **Returns:** `Complex`
- **Throws:** [UndefinedResultException](errors.md) if this number is zero

## Comparison, checks and output

Compare numbers with a tolerance and turn them into text.

### equals()

```php
public function equals(self $other, float $tolerance = 1e-9): bool
```

Checks whether both parts differ by at most an absolute tolerance.

- **Parameters:** `$other` the number to compare with, `$tolerance` the largest allowed difference per part
- **Returns:** `bool`
- **Throws:** [InvalidValueException](errors.md) if the tolerance is negative, `NAN` or infinite

### isZero()

```php
public function isZero(): bool
```

Checks whether both parts are zero. A negative zero counts as zero.

- **Returns:** `bool`

### isReal()

```php
public function isReal(): bool
```

Checks whether the imaginary part is zero, so the number lies on the real axis. Zero is real.

- **Returns:** `bool`

### isImaginary()

```php
public function isImaginary(): bool
```

Checks whether the real part is zero, so the number lies on the imaginary axis. Zero is imaginary.

- **Returns:** `bool`

### isFinite()

```php
public function isFinite(): bool
```

Checks whether both parts are finite. Results of operations can overflow to `INF` or `NAN`, and this tells you.

- **Returns:** `bool`

### __toString()

```php
public function __toString(): string
```

Formats the number as `a+bi` or `a-bi`. Each part is a plain decimal with at most 14 decimals, without an exponent, without trailing zeros and never a negative zero. The result does not depend on the `precision` ini setting.

- **Returns:** `string`
