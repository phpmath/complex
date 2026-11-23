---
title: Arithmetic
intro: Add, subtract, multiply and divide, then negate, conjugate and take the reciprocal.
group: Guides
order: 30
---

## The four operations

`add()`, `subtract()` and `multiply()` take another `Complex` and return the result as a new one. Addition and subtraction work on each part separately. Multiplication follows the rule `(a+bi)(c+di) = (ac-bd) + (ad+bc)i`.

```php
use PHPMath\Complex\Complex;

$a = Complex::of(3, 4);
$b = Complex::of(1, -2);

echo $a->add($b);      // 4+2i
echo $a->subtract($b); // 2+6i
echo $a->multiply($b); // 11-2i
```

Multiplying the imaginary unit by itself gives -1, which is the definition of `i`.

```php
use PHPMath\Complex\Complex;

echo Complex::i()->multiply(Complex::i()); // -1+0i
```

## Division

`divide()` divides this number by another one. It uses Smith's algorithm, which avoids an overflow in the intermediate steps when the parts are large. Dividing by zero throws [`DivisionByZeroException`](errors.md).

```php
use PHPMath\Complex\Complex;

$a = Complex::of(3, 4);
$b = Complex::of(1, -2);

echo $a->divide($b);                        // -1+2i
echo Complex::of(5)->divide(Complex::of(0, 2)); // 0-2.5i
```

> [!WARNING]
> Dividing by `Complex::zero()` is an error. `divide()` and `reciprocal()` both throw `DivisionByZeroException` when the divisor is zero.

## Negation and conjugate

`negate()` flips the sign of both parts. The conjugate of a number has the same real part and the opposite imaginary part. `conjugate()` returns it.

```php
use PHPMath\Complex\Complex;

$z = Complex::of(3, 4);

echo $z->negate();    // -3-4i
echo $z->conjugate(); // 3-4i
```

A number times its conjugate is real. It equals the square of the modulus, see [Polar form](polar-form.md).

```php
use PHPMath\Complex\Complex;

$z = Complex::of(3, 4);

echo $z->multiply($z->conjugate()); // 25+0i
```

## Scaling

`scale()` multiplies both parts by a real factor. It is shorter than multiplying by a `Complex` that has no imaginary part, and the result is the same. The factor must be finite.

```php
use PHPMath\Complex\Complex;

echo Complex::of(1, -2)->scale(3);  // 3-6i
echo Complex::of(1, 2)->scale(-1);  // -1-2i
```

## Reciprocal

`reciprocal()` returns `1/z`. It is the same as dividing `Complex::one()` by the number. A zero number throws `DivisionByZeroException`.

```php
use PHPMath\Complex\Complex;

echo Complex::of(3, 4)->reciprocal(); // 0.12-0.16i
```
