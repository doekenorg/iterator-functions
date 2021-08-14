<?php

/**
 * Tests for {@see iterator_diff()}.
 */

it('diffs two iterators', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3]);
    $iterator_2 = new ArrayIterator([2, 3, 4]);

    $iterator_diff = iterator_diff($iterator_1, $iterator_2);
    $iterator_diff_2 = iterator_diff($iterator_2, $iterator_1);

    expect(iterator_to_array($iterator_diff))->toBe([0 => 1]);
    expect(iterator_to_array($iterator_diff_2))->toBe([2 => 4]);
});

it('diffs more than two iterators', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3, 'one', 'two', 'three']);
    $iterator_2 = new ArrayIterator([2, 3, 4]);
    $iterator_3 = new ArrayIterator(['three', 'four', 'five']);

    $iterator_diff = iterator_diff($iterator_1, $iterator_2, $iterator_3);

    expect(iterator_to_array($iterator_diff))->toBe([0 => 1, 3 => 'one', 4 => 'two']);
});