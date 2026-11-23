---
title: Powers and roots
intro: Raise a number to a power, take the principal square root and find all n-th roots.
group: Guides
order: 50
---

## Integer powers

`pow()` raises a number to a power. When the exponent is a PHP `int`, the library multiplies repeatedly, so the result is exact for exact input. A negative exponent gives the reciprocal of the positive power.

```php
use PHPMath\Complex\Complex;

echo Complex::i()->pow(2);          // -1+0i
echo Complex::of(1, 2)->pow(5);     // 41-38i
echo Complex::of(1, 1)->pow(-2);    // 0-0.5i
echo Complex::of(3, 4)->pow(0);     // 1+0i
```

Zero to the power zero is one. Zero to a negative integer power throws [`DivisionByZeroException`](errors.md). `PHP_INT_MIN` is rejected with `InvalidValueException`, because its absolute value does not fit in an int.

## Real powers

When the exponent is a `float`, `pow()` uses the principal value, `exp(exponent * log(z))`. It works with the modulus and argument, see [Polar form](polar-form.md). The principal value is the one that uses the principal argument and logarithm.

```php
use PHPMath\Complex\Complex;

echo Complex::of(2)->pow(1.5);  // 2.82842712474619+0i
echo Complex::of(-4)->pow(0.5); // 0+2i
```

The result is not exact. The real part of the second example should be exactly 0, but `cos()` of pi/2 is not exactly zero. The text format hides the error because it shows at most 14 decimals. Even a whole exponent gives a rounded result when it is written as a float.

```php
use PHPMath\Complex\Complex;

echo Complex::i()->pow(2);   // -1+0i
echo Complex::i()->pow(2.0); // -1+0i
echo Complex::i()->pow(2.0)->imaginary(); // 1.2246467991474E-16
```

> [!NOTE]
> Pass an `int` when you want a whole-number power. It is exact and faster.

A float exponent that is `NAN` or infinite throws `InvalidValueException`. A float exponent of 0 gives one, even for zero. Zero to a positive float power is zero. Zero to a negative float power throws `DivisionByZeroException`.

## Overflow

Powers can become very large. The library does not check for this, so the result can be `INF`.

```php
use PHPMath\Complex\Complex;

echo Complex::of(10)->pow(400);  // INF+0i
echo Complex::of(10)->pow(-400); // 0+0i
```

## Square root

`sqrt()` returns the principal square root, which has a real part that is not negative. It keeps the precision of the smaller part of the result, so `Complex::of(1, 1.0E-20)->sqrt()` gives `1+0i`, where the imaginary part is `5.0E-21` (use `imaginary()` to read it, the text format shows at most 14 decimals), and it does not overflow for very large numbers. A number has two square roots, and this is the one with the non-negative real part. The square root of a negative real number is a pure imaginary number.

```php
use PHPMath\Complex\Complex;

echo Complex::of(-4)->sqrt();   // 0+2i
echo Complex::of(3, 4)->sqrt(); // 2+1i
echo Complex::i()->sqrt();      // 0.70710678118655+0.70710678118655i
```

## All n-th roots

A non-zero number has exactly n different n-th roots. `roots()` returns all of them in a list. The first one is the principal root, and the others follow counterclockwise around a circle, one n-th of a turn apart.

```php
use PHPMath\Complex\Complex;

foreach (Complex::one()->roots(3) as $root) {
    echo $root, "\n";
}
// 1+0i
// -0.5+0.86602540378444i
// -0.5-0.86602540378444i
```

The cube roots of -8 show why this matters. The principal root is not the real root -2.

```php
use PHPMath\Complex\Complex;

$roots = Complex::of(-8)->roots(3);

echo $roots[0]; // 1+1.73205080756888i
echo $roots[1]; // -2+0i
echo $roots[2]; // 1-1.73205080756888i
```

`roots(1)` returns a list with the number itself. A degree below one throws `InvalidValueException`. All roots of zero are zero.

> [!WARNING]
> `roots()` allocates one `Complex` for every root. A degree of one million creates one million objects, so do not pass untrusted input as the degree.
