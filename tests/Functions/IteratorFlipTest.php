<?php

use DoekeNorg\IteratorFunctions\Iterator\FlipIterator;

it('flips the value and key', function () {
    $iterator = new \ArrayIterator(['one' => 1, 'two' => 2]);
    $flipped = iterator_flip($iterator);

    expect(iterator_to_array($flipped))->toBe([1 => 'one', 2 => 'two']);
});

it('returns a FlipIterator', function () {
    $iterator = iterator_flip(new \ArrayIterator());
    expect($iterator)->toBeInstanceOf(FlipIterator::class);
});
