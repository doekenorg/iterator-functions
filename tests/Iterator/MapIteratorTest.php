<?php

use DoekeNorg\IteratorFunctions\Iterator\MapIterator;

it('maps an iterator', function () {
    $iterator = new ArrayIterator(['one', 'two', 'three']);
    $map_iterator = iterator_map('strtoupper', $iterator);

    expect($map_iterator)->toBeInstanceOf(MapIterator::class);
    expect(iterator_to_array($map_iterator))->toBe(['ONE', 'TWO', 'THREE']);
});

it('preserves keys', function () {
    $iterator = new ArrayIterator(['one' => 'one', 'two' => 'two']);
    $map_iterator = iterator_map('strtoupper', $iterator);

    expect($map_iterator)->toBeInstanceOf(MapIterator::class);
    expect(iterator_to_array($map_iterator))->toBe(['one' => 'ONE', 'two' => 'TWO']);
});

it('maps multiple iterators', function () {
    $iterator = new ArrayIterator([1, 2, 3]);

    $map_iterator = iterator_map(function ($first_value, $second_value) {
        return $first_value . '.' . $second_value;
    }, $iterator, clone $iterator);

    expect(iterator_to_array($map_iterator))->toBe(['1.1', '2.2', '3.3']);
});

it('throws an exception when the callback arguments do not match', function () {
    $iterator = new ArrayIterator();
    iterator_map(static fn($one, $two) => '', $iterator);
})->throws('The callback needs as many arguments as provided iterators.');

it('doesn\'t throw an exception when the callback is variadic', function () {
    $iterator = new ArrayIterator([1, 2]);
    $map_iterator = iterator_map(static fn(...$values) => implode('.', $values), $iterator, clone $iterator);
    expect(iterator_to_array($map_iterator))->toBe(['1.1', '2.2']);
});
