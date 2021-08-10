<?php

use DoekeNorg\IteratorFunctions\Iterator\MapIterator;

/**
 * Tests for {@see iterator_map()}.
 * @since $ver$
 */
it('maps an iterator', function () {
    $iterator = new ArrayIterator(['one', 'two', 'three']);
    $map_iterator = iterator_map('strtoupper', $iterator);

    expect($map_iterator)->toBeInstanceOf(MapIterator::class);
    expect(iterator_to_array($map_iterator))->toBe(['ONE', 'TWO', 'THREE']);
});