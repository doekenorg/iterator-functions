# Iterator functions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/doekenorg/iterator-functions.svg?style=flat-square)](https://packagist.org/packages/doekenorg/iterator-functions)
[![Tests](https://github.com/doekenorg/iterator-functions/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/doekenorg/iterator-functions/actions/workflows/run-tests.yml)

The `doekenorg/iterator-functions` package provides a curated set of `array_*` like functions for iterators in PHP. This
package is built to encourage developers to make more use of `Iterators` by simplifying common tasks.

## Available functions

All available functions are modeled after their `array_*` equivalent. But instead of returning an `array` it will return
an `Iterator` instance. This means that you can use them in the same way, but get the added memory preserving benefits.

- `iterator_column(\Traversable $iterator, $column_key, $index_key = null): ColumnIterator`
- `iterator_filter(Iterator $iterator, ?callable $callback = null): \CallbackFilterIterator`
- `iterator_flip(Iterator $iterator): FlipIterator`
- `iterator_keys(\Iterator $iterator): KeysIterator`
- `iterator_map(callable $callback, iterable ...$iterators): MapIterator`
- `iterator_reduce(\Iterator $iterator, callable $callback, $initial = null)`
- `iterator_values(\Iterator $iterator): ValuesIterator`
- `iterator_walk(\Iterator $iterator, callable $callback, ...$arguments): void`

*Note:* There are no `_diff` or `_intersect` functions available, because these are not possible without forgoing on the
memory benefits of iterators.

## Available iterators

Where possible the functions make use of native iterators. Any missing iterators were added to this package.

- `ColumnIterator` - Iterator that returns a single column for the iteration array / object.
- `FlipIterator` - Iterator that flips the key and the value of the current iteration.
- `KeysIterator` - Iterator that returns only the keys of the provided iterator.
- `MapIterator` - Iterator that applies a callback to the elements of the given iterators.
- `ValuesIterator` - Iterator that returns only the values of the provided iterator.

## Install

You can install the package via composer:

``` bash
composer require doekenorg/iterator-functions
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing
```bash
./vendor/bin/pest
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
