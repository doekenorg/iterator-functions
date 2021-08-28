<?php

/**
 * Tests for {@see iterator_walk()}.
 */
it('walks an iterator', function () {
    $objects = [
        (object) ['title' => 'Title 1'],
        (object) ['title' => 'Title 2'],
    ];
    $iterator = new ArrayIterator($objects);

    iterator_walk($iterator, function (object $object, int $key, $arg1, $arg2) {
        $object->title = implode('.', [$object->title, $key, $arg1, $arg2]);
    }, 'one', 'two');

    expect($objects[0]->title)->toBe('Title 1.0.one.two');
    expect($objects[1]->title)->toBe('Title 2.1.one.two');
});
