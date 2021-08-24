<?php

/**
 * Tests for {@see iterator_reduce()}.
 */
it('reduces an iterator', function () {
    $iterator = new \ArrayIterator([1, 2, 3]);
    $result = iterator_reduce($iterator, function ($carry, string $value) {
        return $carry . '-' . $value;
    }, 'initial');

    expect($result)->toBe('initial-1-2-3');
});

it('reduces to null without values', function () {
    $iterator = new \ArrayIterator([]);
    $result = iterator_reduce($iterator, static fn ($carry, $value) => $value);

    expect($result)->toBeNull();
});
