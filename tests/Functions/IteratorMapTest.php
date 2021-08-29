<?php

use DoekeNorg\IteratorFunctions\Iterator\MapIterator;
use DoekeNorg\IteratorFunctions\Tests\Assets\Functions;

/**
 * Tests for {@see iterator_map()}.
 */
it('maps an iterator', function () {
    $iterator = new ArrayIterator(['one', 'two', 'three']);
    $map_iterator = iterator_map('strtoupper', $iterator);

    expect($map_iterator)->toBeInstanceOf(MapIterator::class);
    expect(iterator_to_array($map_iterator))->toBe(['ONE', 'TWO', 'THREE']);
});

it('maps an array as an iterator', function () {
    $map_iterator = iterator_map('strtoupper', ['one', 'two', 'three']);

    expect($map_iterator)->toBeInstanceOf(MapIterator::class);
    expect(iterator_to_array($map_iterator))->toBe(['ONE', 'TWO', 'THREE']);
});

it('maps with a callback via array params', function () {
    $functions = new Functions();
    $map_iterator = iterator_map([$functions, 'strtoupper'], ['one', 'two', 'three']);

    expect($map_iterator)->toBeInstanceOf(MapIterator::class);
    expect(iterator_to_array($map_iterator))->toBe(['ONE', 'TWO', 'THREE']);
});
