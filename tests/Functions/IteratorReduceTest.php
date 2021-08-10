<?php

it('reduces an iterator', function () {
    $iterator = new \ArrayIterator([1, 2, 3]);
    $result = iterator_reduce($iterator, function ($carry, string $value) {
        return $carry . '-' . $value;
    }, 'initial');

    expect($result)->toBe('initial-1-2-3');
});
