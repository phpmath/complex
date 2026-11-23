---
title: Introduction
intro: Complex numbers for PHP. Every number is an immutable value object with a float real and a float imaginary part.
group: Getting started
order: 10
---

## Requirements

The library needs a current PHP version. It has no runtime dependencies and no extensions are required.

- PHP 8.4 or newer

## Installation

Install the library with Composer.

```bash
composer require phpmath/complex
```

## A first example

A complex number has a real part and an imaginary part. You write it as `a+bi`, where `i` is the imaginary unit (the number whose square is -1). Create one with `Complex::of()`, then combine numbers with methods such as `add()` and `multiply()`.

```php
use PHPMath\Complex\Complex;

$a = Complex::of(3, 4);
$b = Complex::of(1, -2);

echo $a->add($b);      // 4+2i
echo $a->multiply($b); // 11-2i
echo $a->modulus();    // 5
```

Calling `add()` did not change `$a`. It returned a new `Complex`. This is true for every operation in the library.

> [!NOTE]
> The parts are PHP floats, so results follow normal float rules. They can be slightly inexact, and a very large result can become `INF` or `NAN`. See [Core concepts](concepts.md#float-behavior).

## Where to go next

Start with the core concepts, or jump straight to the topic you need.

<div class="cards"><a href="concepts.md"><strong>Core concepts</strong><span>Immutability, creating numbers, reading values and errors.</span></a><a href="arithmetic.md"><strong>Arithmetic</strong><span>Add, subtract, multiply, divide, negate and conjugate.</span></a><a href="polar-form.md"><strong>Polar form</strong><span>Modulus, argument and creating numbers from angles.</span></a><a href="powers-and-roots.md"><strong>Powers and roots</strong><span>Integer and real powers, square roots and all n-th roots.</span></a><a href="exp-and-log.md"><strong>Exp and log</strong><span>The exponential function and the principal logarithm.</span></a><a href="comparison.md"><strong>Comparison and output</strong><span>Equality with a tolerance and the text format.</span></a><a href="api.md"><strong>API reference</strong><span>Every method with its parameters and errors.</span></a></div>
