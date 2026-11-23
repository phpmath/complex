---
title: Core concepts
intro: The few ideas you need to use Complex well.
group: Getting started
order: 20
---

## Numbers are immutable

`Complex` is a `final readonly` class. Once created, a number never changes. Methods such as `add()` or `negate()` return a new instance and leave the original untouched, so you can pass numbers around without defensive copies.

```php
use PHPMath\Complex\Complex;

$z = Complex::of(2, 3);
$next = $z->add(Complex::one());

echo $z;    // 2+3i
echo $next; // 3+3i
```

## Creating numbers

There is no public constructor. You create a number with one of five named constructors. `of()` takes the real and imaginary part. `fromPolar()` takes a modulus and an argument, see [Polar form](polar-form.md). `zero()`, `one()` and `i()` return the constants 0, 1 and the imaginary unit.

```php
use PHPMath\Complex\Complex;

echo Complex::of(3, 4); // 3+4i
echo Complex::of(3);    // 3+0i
echo Complex::zero();   // 0+0i
echo Complex::one();    // 1+0i
echo Complex::i();      // 0+1i
```

The input of the named constructors must be finite. A `NAN` or infinite part throws [`InvalidValueException`](errors.md).

```php
use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\InvalidValueException;

try {
    Complex::of(INF, 0);
} catch (InvalidValueException $exception) {
    echo $exception->getMessage(); // The real and imaginary part must be finite.
}
```

## Reading values

`real()` and `imaginary()` return the two parts as floats. `modulus()` and `argument()` return the polar form, which is described in [Polar form](polar-form.md). To get a text, cast the number to a string, see [Comparison and output](comparison.md).

```php
use PHPMath\Complex\Complex;

$z = Complex::of(3, 4);

echo $z->real();      // 3
echo $z->imaginary(); // 4
echo $z->modulus();   // 5
```

> [!NOTE]
> A `Complex` is printed with at most 14 decimals, so the stored value can have more digits than the text shows. Floats printed on their own, for example with `echo $z->real()`, follow PHP's `precision` setting. Examples in this documentation show the printed result.

## Operations take Complex arguments

Methods that combine two numbers accept another `Complex`, not an int or a float. Wrap raw values with `Complex::of()` first.

```php
use PHPMath\Complex\Complex;

$z = Complex::of(1, 1);

$z->add(Complex::of(5)); // correct
$z->add(5);              // TypeError
```

Methods that need a plain count, such as `pow()` and `roots()`, take a PHP `int` or `float`, as described on their pages.

## Float behavior

The real and imaginary part are PHP floats. The library checks the input of the named constructors, but it does not check the results of operations. A result can therefore be slightly inexact, and an overflow gives `INF` or `NAN`, just like plain float arithmetic. Call `isFinite()` on a result to find out whether that happened.

```php
use PHPMath\Complex\Complex;

$big = Complex::of(1e200);

echo $big->multiply($big);          // INF+0i
echo Complex::of(1000)->exp();      // INF+NANi
```

Keep these points in mind.

- Use [`equals()`](comparison.md) instead of `==` or `===`. It compares with an absolute tolerance.
- A number that holds `INF` or `NAN` never equals anything, not even itself.
- `roots()` allocates one `Complex` for every root, so a large degree uses a lot of memory.

## Errors

Every exception the library throws implements `ComplexException`, so one `catch` block can handle all of them. The library has three exceptions: `InvalidValueException`, `DivisionByZeroException` and `UndefinedResultException`. See [Errors and exceptions](errors.md) for when each one is thrown.

```php
use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\ComplexException;

try {
    Complex::one()->divide(Complex::zero());
} catch (ComplexException $exception) {
    echo $exception->getMessage(); // Cannot divide by zero.
}
```
