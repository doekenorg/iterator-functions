<?php

/**
 * Tests for {@see iterator_values()}.
 */

use DoekeNorg\IteratorFunctions\Iterator\ValuesIterator;

it('returns only the values of an iterator', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $iterator_values = iterator_values($iterator);
    expect(iterator_to_array($iterator_values))->toBe([1, 2]);
});

it('returns a ValuesIterator', function() {
    $iterator_values = iterator_values(new ArrayIterator());
    expect($iterator_values)->toBeInstanceOf(ValuesIterator::class);
});
