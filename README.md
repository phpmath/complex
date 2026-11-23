# complex

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![CI][ico-ci]][link-ci]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP library to work with immutable complex numbers.

## Documentation

The full documentation is at https://phpmath.github.io/complex/. Every change is listed in the [changelog](CHANGELOG.md) and every release on the [releases page](https://github.com/phpmath/complex/releases).

## Install

```bash
composer require phpmath/complex
```

## Requirements

- PHP 8.4 or newer

## Usage

Every complex number is an immutable value object with a float real and a float imaginary part. Operations never
change the instance they are called on, they return a new instance.

``` php
use PHPMath\Complex\Complex;

$a = Complex::of(3, 4);
$b = Complex::of(1, -2);

echo $a->add($b);           // 4+2i
echo $a->multiply($b);      // 11-2i
echo $a->divide($b);        // -1+2i
echo $a->modulus();         // 5
echo $a->conjugate();       // 3-4i

echo Complex::i()->pow(2);  // -1+0i
echo Complex::of(-4)->sqrt(); // 0+2i

$roots = Complex::one()->roots(3); // list of the three cube roots of unity

$a->equals(Complex::of(3.0000000001, 4), 1e-6); // true
```

## Features

* Creating numbers with `of()`, `fromPolar()`, `zero()`, `one()` and `i()`.
* Reading `real()`, `imaginary()`, `modulus()` and `argument()`.
* Arithmetic with `add()`, `subtract()`, `multiply()`, `divide()`, `negate()`, `conjugate()` and `reciprocal()`.
* Powers with `pow()` (integer and real exponents), the principal `sqrt()`, `exp()` and `log()`, and all n-th `roots()`.
* Comparing with `equals()`, which accepts an absolute tolerance, and formatting with `__toString()` (`3+4i`).

Invalid input is reported with exceptions in the `PHPMath\Complex\Exception` namespace, all of which implement
`ComplexException`: `InvalidValueException`, `DivisionByZeroException` and `UndefinedResultException`.

## Development

```bash
composer test
composer test-coverage
composer analyse
composer check-style
composer fix-style
```

## Contributing

All contributions are welcome. Open an issue or a pull request on GitHub. Please follow the coding standard and add tests.

## Security

If you discover a security issue, please create an issue in the issue tracker.

## Credits

- [Walter Tamboer](https://github.com/waltertamboer)
- [All contributors](https://github.com/phpmath/complex/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/phpmath/complex.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://img.shields.io/github/actions/workflow/status/phpmath/complex/ci.yml?branch=master&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phpmath/complex.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phpmath/complex
[link-ci]: https://github.com/phpmath/complex/actions/workflows/ci.yml
[link-downloads]: https://packagist.org/packages/phpmath/complex/stats
