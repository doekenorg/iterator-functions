<?php

use DoekeNorg\IteratorFunctions\Iterator\FlipIterator;

/**
 * Tests for {@see FlipIterator}.
 */
it('flips the value and key', function () {
    $iterator = new ArrayIterator(['one' => 1, 'two' => 2]);
    $flipped = new FlipIterator($iterator);

    expect(iterator_to_array($flipped))->toBe([1 => 'one', 2 => 'two']);
});
