<?php

/**
 * Tests for {@see iterator_diff()}.
 */

it('diffs two iterators', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3]);
    $iterator_2 = new ArrayIterator([2, 3, 4]);

    $result_1 = iterator_diff($iterator_1, $iterator_2);
    $result_2 = iterator_diff($iterator_2, $iterator_1);

    expect(iterator_to_array($result_1))->toBe([0 => 1]);
    expect(iterator_to_array($result_2))->toBe([2 => 4]);
});

it('diffs more than two iterators', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3, 'one', 'two', 'three']);
    $iterator_2 = new ArrayIterator([2, 3, 4]);
    $iterator_3 = new ArrayIterator(['three', 'four', 'five']);

    $result = iterator_diff($iterator_1, $iterator_2, $iterator_3);

    expect(iterator_to_array($result))->toBe([0 => 1, 3 => 'one', 4 => 'two']);
});

/**
 * Tests for {@see iterator_diff_assoc()}.
 */
it('diffs two iterators associatively', function () {
    $iterator_1 = new ArrayIterator(['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red']);
    $iterator_2 = new ArrayIterator(['a' => 'green', 'yellow', 'red']);

    $result = iterator_diff_assoc($iterator_1, $iterator_2);

    expect(iterator_to_array($result))->toBe(['b' => 'brown', 'c' => 'blue', 0 => 'red']);
});

/**
 * Tests for {@see iterator_diff_key()}.
 */

it('can diff by key', function () {
    $iterator_1 = new ArrayIterator(['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4]);
    $iterator_2 = new ArrayIterator(['green' => 5, 'yellow' => 7, 'cyan' => 8]);

    $result = iterator_diff_key($iterator_1, $iterator_2);
    expect(iterator_to_array($result))->toBe(['blue' => 1, 'red' => 2, 'purple' => 4]);
});
