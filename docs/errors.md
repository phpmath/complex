---
title: Errors and exceptions
intro: What can go wrong and how to catch it.
group: Reference
order: 90
---

## Library exceptions

Every exception implements the marker interface `PHPMath\Complex\Exception\ComplexException`, so one `catch` block can handle all of them. Each one is a final class that also extends exactly one standard PHP exception, chosen by the cause. The library never throws a plain PHP exception on purpose.

| Exception | Extends | Thrown when |
|---|---|---|
| `PHPMath\Complex\Exception\InvalidValueException` | `\InvalidArgumentException` | An argument is not acceptable. See the list below. |
| `PHPMath\Complex\Exception\DivisionByZeroException` | `\InvalidArgumentException` | The divisor is the number zero. |
| `PHPMath\Complex\Exception\UndefinedResultException` | `\DomainException` | An operation has no defined result. |

## When InvalidValueException is thrown

This table lists every case where a method rejects its argument.

| Method | Condition |
|---|---|
| `of()` | The real or imaginary part is `NAN` or infinite. |
| `fromPolar()` | The modulus or argument is `NAN` or infinite, or the modulus is negative. |
| `pow()` | A float exponent is `NAN` or infinite, or the int exponent is `PHP_INT_MIN`. |
| `roots()` | The degree is below 1. |
| `equals()` | The tolerance is negative, `NAN` or infinite. |
| `scale()` | The factor is `NAN` or infinite. |

## When DivisionByZeroException is thrown

This table lists every case where a division by zero is detected. Zero means both parts are exactly zero.

| Method | Condition |
|---|---|
| `divide()` | The divisor is zero. |
| `reciprocal()` | This number is zero. |
| `pow()` | This number is zero and the exponent is negative. The message is "Cannot raise zero to a negative power." for int and float exponents. |

## When UndefinedResultException is thrown

This exception is thrown by one method only.

| Method | Condition |
|---|---|
| `log()` | This number is zero. |

## What is not an error

Operations do not check their results. An overflow gives `INF` or `NAN` and no exception, for example in `multiply()`, `pow()`, `exp()`, `fromPolar()` and `roots()`. Use `isFinite()` to detect it. See [Core concepts](concepts.md#float-behavior).

## Handling errors

Catch the specific exception when you can recover, or `ComplexException` to handle all of them.

```php
use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\DivisionByZeroException;
use PHPMath\Complex\Exception\InvalidValueException;

try {
    Complex::of(1, 1)->divide(Complex::zero());
} catch (DivisionByZeroException $exception) {
    echo $exception->getMessage(); // Cannot divide by zero.
}

try {
    Complex::of(1, 1)->roots(0);
} catch (InvalidValueException $exception) {
    echo $exception->getMessage(); // The degree of the roots must be at least one.
}
```

To handle every library error in one place, catch the marker interface.

```php
use PHPMath\Complex\Complex;
use PHPMath\Complex\Exception\ComplexException;

try {
    Complex::zero()->log();
} catch (ComplexException $exception) {
    echo $exception::class . ': ' . $exception->getMessage();
}
```

The output is:

```text
PHPMath\Complex\Exception\UndefinedResultException: The logarithm of zero is undefined.
```
