<?php

use DoekeNorg\IteratorFunctions\Iterator\KeysIterator;

/**
 * Tests for {@see KeysIterator}.
 */
it('returns only the keys of the iterator', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $iterator_values = new KeysIterator($iterator);
    expect(iterator_to_array($iterator_values))->toBe(['one', 'two']);
});

it('can be rewound', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $iterator_values = new KeysIterator($iterator);
    expect(iterator_to_array($iterator_values))->toBe(['one', 'two']);
    expect(iterator_to_array($iterator_values))->toBe(['one', 'two']); // rewinds the iterator
});
