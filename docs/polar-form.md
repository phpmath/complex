---
title: Polar form
intro: Describe a number by its distance and angle instead of its two parts.
group: Guides
order: 40
---

## Modulus and argument

A complex number is a point on a plane. The modulus is its distance from the origin. The argument is the angle, in radians, between the positive real axis and the line to the point. Together they are the polar form of the number.

`modulus()` returns the distance and `argument()` returns the angle.

```php
use PHPMath\Complex\Complex;

$z = Complex::of(1, 1);

echo $z->modulus();  // 1.4142135623731
echo $z->argument(); // 0.78539816339745
```

`modulus()` uses `hypot()`, so it does not overflow too early. For `3+4i` the result is exactly 5.

```php
use PHPMath\Complex\Complex;

echo Complex::of(3, 4)->modulus(); // 5
```

## The principal argument

Adding a full turn (2 pi) to an angle describes the same point, so a number has many arguments. The principal value is the one the library returns. It lies in the range from -pi (exclusive) to pi (inclusive). The argument of -1 is therefore pi.

```php
use PHPMath\Complex\Complex;

echo Complex::of(-1, 0)->argument(); // 3.1415926535898
```

The argument of zero is not defined mathematically. The library returns 0 for it and does not throw.

> [!NOTE]
> A negative zero in the imaginary part is treated as a positive zero. `Complex::of(-1, -0.0)->argument()` returns pi, not -pi, so a number on the negative real axis always has the argument pi.

## Creating from polar form

`fromPolar()` builds a number from a modulus and an argument. The modulus must not be negative and both values must be finite. Otherwise it throws [`InvalidValueException`](errors.md).

```php
use PHPMath\Complex\Complex;

$z = Complex::fromPolar(2, M_PI / 4);

echo $z; // 1.4142135623731+1.4142135623731i
```

The conversion uses `cos()` and `sin()`, so the result is not exact. A number that should be real can get a tiny imaginary part. The text format shows at most 14 decimals, so it hides such a part, but `imaginary()` returns it.

```php
use PHPMath\Complex\Complex;

echo Complex::fromPolar(1, M_PI);                     // -1+0i
echo Complex::fromPolar(1, M_PI)->imaginary();  // 1.2246467991474E-16
```

Compare such results with [`equals()`](comparison.md) and not with `==`.
