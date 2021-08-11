<?php

use \DoekeNorg\IteratorFunctions\Iterator\ColumnIterator;

/**
 * Tests for {@see ColumnIterator}.
 */
it('returns a single column for an iterator with arrays', function () {
    $titles = [
        ['id' => 1, 'title' => 'Title 1'],
        ['id' => 2, 'title' => 'Title 2'],
    ];

    $iterator = new ArrayIterator($titles);
    $column_iterator = new ColumnIterator($iterator, 'title');

    expect(iterator_to_array($column_iterator))->toBe(['Title 1', 'Title 2']);
});

it('uses the index key as a key', function () {
    $titles = [
        ['id' => 1, 'title' => 'Title 1'],
        ['id' => 2, 'title' => 'Title 2'],
    ];

    $iterator = new ArrayIterator($titles);
    $column_iterator = new ColumnIterator($iterator, 'title', 'id');

    expect(iterator_to_array($column_iterator))->toBe([1 => 'Title 1', 2 => 'Title 2']);
});

it('replaces the key and keeps the array intact', function () {
    $titles = [
        ['id' => 1, 'title' => 'Title 1'],
        ['id' => 2, 'title' => 'Title 2'],
    ];

    $iterator = new ArrayIterator($titles);
    $column_iterator = new ColumnIterator($iterator, null, 'id');

    expect(iterator_to_array($column_iterator))->toBe([
        1 => $titles[0],
        2 => $titles[1],
    ]);
});

it('returns a single column for an iterator with objects', function() {
    $titles = [
        (object) ['id' => 1, 'title' => 'Title 1'],
        (object) ['id' => 2, 'title' => 'Title 2'],
    ];

    $iterator = new ArrayIterator($titles);
    $column_iterator = new ColumnIterator($iterator, 'title', 'id');

    expect(iterator_to_array($column_iterator))->toBe([1 => 'Title 1', 2 => 'Title 2']);
});
