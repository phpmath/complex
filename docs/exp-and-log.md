---
title: Exp and log
intro: The exponential function and the principal natural logarithm.
group: Guides
order: 60
---

## Exponential

`exp()` returns e raised to this number. For `a+bi` the result is `e^a` times `cos(b)` plus `e^a` times `sin(b)` times `i`. This links the imaginary part to a rotation.

```php
use PHPMath\Complex\Complex;

echo Complex::of(1)->exp();       // 2.71828182845905+0i
echo Complex::of(0, 2)->exp();    // -0.41614683654714+0.90929742682568i
```

Euler's identity says that `e^(i*pi)` is -1. The stored result has a tiny imaginary part because of float rounding, which the text format does not show because it is below 14 decimals.

```php
use PHPMath\Complex\Complex;

echo Complex::of(0, M_PI)->exp();                       // -1+0i
echo Complex::of(0, M_PI)->exp()->imaginary();    // 1.2246467991474E-16
```

## Overflow of exp

`exp()` does not check its result. A real part above about 709 overflows to `INF`, and the product with the sine of the imaginary part can then be `NAN`. A very negative real part gives zero.

```php
use PHPMath\Complex\Complex;

echo Complex::of(1000)->exp();  // INF+NANi
echo Complex::of(-1000)->exp(); // 0+0i
```

## Natural logarithm

`log()` returns the principal natural logarithm. The real part is the logarithm of the modulus. The imaginary part is the principal argument, see [Polar form](polar-form.md). The principal logarithm is the one whose imaginary part is the principal argument, because every number has many logarithms.

```php
use PHPMath\Complex\Complex;

echo Complex::of(M_E)->log();   // 1+0i
echo Complex::of(-1)->log();    // 0+3.14159265358979i
echo Complex::of(1, 1)->log();  // 0.34657359027997+0.78539816339745i
```

The logarithm of zero is not defined. `log()` throws [`UndefinedResultException`](errors.md) for it.

```php
use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\UndefinedResultException;

try {
    Complex::zero()->log();
} catch (UndefinedResultException $exception) {
    echo $exception->getMessage(); // The logarithm of zero is undefined.
}
```

## Exp and log are inverses

Applying `exp()` to a logarithm gives the original number back, up to rounding. Use `equals()` to check it.

```php
use PHPMath\Complex\Complex;

$z = Complex::of(1, 1);
$back = $z->log()->exp();

echo $back;                              // 1+1i
echo $back->equals($z) ? 'yes' : 'no';   // yes
echo $back == $z ? 'yes' : 'no';         // no
```
