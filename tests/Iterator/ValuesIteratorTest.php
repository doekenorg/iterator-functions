<?php

use DoekeNorg\IteratorFunctions\Iterator\ValuesIterator;

/**
 * Tests for {@see ValuesIterator}.
 */

it('works like array_values', function () {
    $array = ['name', null, 'age', ''];
    $result_array = array_values($array);

    expect(iterator_to_array(new ValuesIterator(new ArrayIterator($array))))->toBe($result_array);
});

it('returns only the keys of the iterator', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $iterator_values = new ValuesIterator($iterator);
    expect(iterator_to_array($iterator_values))->toBe([1, 2]);
});

it('can be rewound', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $iterator_values = new ValuesIterator($iterator);
    expect(iterator_to_array($iterator_values))->toBe([1, 2]);
    // keys should be 0 and 1 again
    expect(iterator_to_array($iterator_values))->toBe([1, 2]);
});
