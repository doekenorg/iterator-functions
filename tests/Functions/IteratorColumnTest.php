<?php

/**
 * Tests for {@see iterator_column()}.
 * @since $ver$
 */

use DoekeNorg\IteratorFunctions\Iterator\ColumnIterator;

it('returns a single column for an iterator with arrays', function () {
    $titles = [
        ['id' => 1, 'title' => 'Title 1'],
        ['id' => 2, 'title' => 'Title 2'],
    ];

    $iterator = new ArrayIterator($titles);
    $column_iterator = iterator_column($iterator, 'title');

    expect(iterator_to_array($column_iterator))->toBe(['Title 1', 'Title 2']);
});
it('returns a ColumnIterator', function () {
    $iterator = new ArrayIterator();
    $column_iterator = iterator_column($iterator, 'title');

    expect($column_iterator)->toBeInstanceOf(ColumnIterator::class);
});