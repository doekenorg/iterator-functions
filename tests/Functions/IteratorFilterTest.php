<?php

/**
 * Tests for {@see iterator_filter()}.
 * @since $ver$
 */
it('filters an iterator', function () {
    $iterator = new \ArrayIterator(['one', 'two', 'three']);
    $filtered = iterator_filter($iterator, fn(string $value) => $value !== 'two');
    expect(iterator_to_array($filtered))->toBe([0 => 'one', 2 => 'three']);
});

it('filters empty by default', function () {
    $iterator = new \ArrayIterator(['one', '', null, 0, 'three']);
    $filtered = iterator_filter($iterator);
    expect(iterator_to_array($filtered))->toBe([0 => 'one', 4 => 'three']);
});

it('returns a CallbackFilterIterator', function() {
    $iterator = iterator_filter(new \ArrayIterator());
    expect($iterator)->toBeInstanceOf(\CallbackFilterIterator::class);
});