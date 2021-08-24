<?php

/**
 * Tests for {@see iterator_keys()}.
 */

use DoekeNorg\IteratorFunctions\Iterator\KeysIterator;

/**
 * Tests for {@see iterator_keys()).
 */
it('returns only the keys of the iterator', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $iterator_values = iterator_keys($iterator);
    expect(iterator_to_array($iterator_values))->toBe(['one', 'two']);
});

it('returns a KeysIterator', function () {
    $iterator_values = iterator_keys(new ArrayIterator());
    expect($iterator_values)->toBeInstanceOf(KeysIterator::class);
});
