<?php

use DoekeNorg\IteratorFunctions\Iterator\ColumnIterator;

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

it('returns a single column for an iterator with objects', function () {
    $titles = [
        (object) ['id' => 1, 'title' => 'Title 1'],
        (object) ['id' => 2, 'title' => 'Title 2'],
    ];

    $iterator = new ArrayIterator($titles);
    $column_iterator = new ColumnIterator($iterator, 'title', 'id');

    expect(iterator_to_array($column_iterator))->toBe([1 => 'Title 1', 2 => 'Title 2']);
});

it('contains integer keys when the key is missing', function () {
    // make sure array_column and iterator_column act the same
    $array = [['age' => 32], ['name' => 'Doeke', 'age' => 33], ['age' => 45]];
    $result_array = array_column($array, 'age', 'name');
    $result_iterator = new ColumnIterator(new ArrayIterator($array), 'age', 'name');

    expect($result_array)->toBe(iterator_to_array($result_iterator));
});

it('skips empty values the value-key is missing', function () {
    // make sure array_column and iterator_column act the same
    $array = [['age' => 32], ['name' => 'Doeke', 'age' => 33], ['age' => 45]];
    $result_array = array_column($array, 'name', 'age');
    $result_iterator = new ColumnIterator(new ArrayIterator($array), 'name', 'age');

    expect($result_array)->toBe(iterator_to_array($result_iterator));
});
