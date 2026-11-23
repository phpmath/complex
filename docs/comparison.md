---
title: Comparison and output
intro: Compare numbers with a tolerance and turn them into text.
group: Guides
order: 70
---

## Equality with a tolerance

Float results are rarely exact, so `==` and `===` are unreliable. `equals()` returns `true` when the real parts differ by at most the tolerance and the imaginary parts differ by at most the tolerance. The tolerance is absolute, not relative, and it defaults to `1e-9`.

```php
use PHPMath\Complex\Complex;

$a = Complex::of(3, 4);

var_dump($a->equals(Complex::of(3.0000000001, 4))); // bool(true)
var_dump($a->equals(Complex::of(3.1, 4)));          // bool(false)
var_dump($a->equals(Complex::of(3.1, 4), 0.2));     // bool(true)
```

## Choosing a tolerance

An absolute tolerance works well for numbers near 1, but not for very large or very small ones. Two big numbers can differ by more than 1e-9 and still be as close as floats allow. Pass a tolerance that fits your numbers.

```php
use PHPMath\Complex\Complex;

$a = Complex::of(1e20);
$b = Complex::of(1e20 + 1e5);

var_dump($a->equals($b));       // bool(false)
var_dump($a->equals($b, 1e6));  // bool(true)
```

A negative, `NAN` or infinite tolerance throws [`InvalidValueException`](errors.md). A number with `INF` or `NAN` parts is never equal to anything, because the difference is `NAN` or infinite.

## Checking the kind of number

`isZero()`, `isReal()` and `isImaginary()` tell you where a number lies. A real number has no imaginary part, an imaginary number has no real part, and zero is both. These checks are exact, so they compare the parts with zero and use no tolerance. `isFinite()` is `false` as soon as one part is `INF` or `NAN`, which is how you detect an overflow.

```php
use PHPMath\Complex\Complex;

var_export(Complex::zero()->isZero());      // true
var_export(Complex::of(3, 0)->isReal());    // true
var_export(Complex::of(0, 3)->isImaginary()); // true
var_export(Complex::zero()->isReal());      // true

$big = Complex::of(PHP_FLOAT_MAX)->add(Complex::of(PHP_FLOAT_MAX));

echo $big;                          // INF+0i
var_export($big->isFinite());       // false
var_export(Complex::of(1, 2)->isFinite()); // true
```

## Converting to text

A `Complex` implements `Stringable`. The text has the form `a+bi` or `a-bi`. Each part is a plain decimal with at most 14 decimals, without an exponent, without trailing zeros and never a negative zero. The text does not depend on the `precision` ini setting. Values below 0.00000000000001 print as 0, and `INF` and `NAN` appear as they are. The vector, matrix and quaternion libraries use the same number format.

```php
use PHPMath\Complex\Complex;

echo Complex::of(1.5, -2.25);   // 1.5-2.25i
echo Complex::of(1e25, 1e-7);   // 10000000000000000905969664+0.0000001i
echo Complex::of(0.1 + 0.2, 1e-20); // 0.3+0i
echo Complex::of(1e200)->multiply(Complex::of(1e200)); // INF+0i
```

A negative zero is printed as zero, so `Complex::of(-0.0, -0.0)` gives `0+0i`.

> [!NOTE]
> The text uses the sign of the imaginary part and prints its absolute value. It is meant for display and debugging. Use `real()` and `imaginary()` when you need the values.
