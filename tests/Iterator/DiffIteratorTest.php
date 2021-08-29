<?php

use DoekeNorg\IteratorFunctions\Iterator\DiffIterator;

/**
 * Tests for {@see DiffIterator}.
 * All other features are tested through the iterator_diff tests.
 */
it('throws an exception when withKey and withAssociative are used', function () {
    $inner = new ArrayIterator(['one']);
    iterator_to_array((new DiffIterator($inner, $inner))->withKey()->withAssociative());
})->expectExceptionObject(new \InvalidArgumentException(
    'Can only use one of "withKey" or "withAssociative", not both.'
));

it('can diff', function () {
    $iterator_1 = new ArrayIterator(['one', 'two']);
    $iterator_2 = new ArrayIterator(['one']);
    $result = iterator_to_array(new DiffIterator($iterator_1, $iterator_2));

    expect($result)->toBe([1 => 'two']);
});

it('can extract params form a function', function () {
    $result = DiffIterator::extractParams([
        $iterator = new ArrayIterator(),
        $iterator_clone = clone $iterator,
        $iterator_clone,
        $callable = fn () => '',
        $callable,
    ]);

    expect($result)->toBe([
        $iterator,
        [$iterator_clone, $iterator_clone],
        [$callable, $callable],
    ]);
});

it('throws an exception if the first parameter is not an iterator', function () {
    DiffIterator::extractParams([fn () => '']);
})->expectExceptionObject(new \InvalidArgumentException('First parameter must be an iterator.'));

it('throws an exception if a parameter is not a callable or iterator.', function () {
    DiffIterator::extractParams([new ArrayIterator(), 'invalid']);
})->expectExceptionObject(new \InvalidArgumentException('Argument should be an iterator or callback; "invalid" given.'));

it('throws an exception if there is no iterator to compare against.', function () {
    DiffIterator::extractParams([new ArrayIterator()]);
})->expectExceptionObject(new \InvalidArgumentException('There is no iterator to match against.'));

it('throws an exception if an iterator is added after a callback.', function () {
    DiffIterator::extractParams([new ArrayIterator(), new ArrayIterator(), fn () => '', new ArrayIterator()]);
})->expectExceptionObject(new \InvalidArgumentException('An iterator may not be provided after a callback.'));
