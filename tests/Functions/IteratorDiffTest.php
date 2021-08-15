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

/**
 * Tests for {@see iterator_diff_ukey()}.
 */
it('can diff by key using a callback', function () {
    $compare_func = function ($key_1, $key_2) {
        // green is always different
        if ($key_1 === $key_2 && !in_array('green', [$key_1, $key_2], true)) {
            return 0;
        }

        return 1;
    };
    $iterator_1 = new ArrayIterator(['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4]);
    $iterator_2 = new ArrayIterator(['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8]);

    $result = iterator_diff_ukey($iterator_1, $iterator_2, $compare_func);
    expect(iterator_to_array($result))->toBe(['red' => 2, 'green' => 3, 'purple' => 4]);
});

/**
 * Tests for {@see iterator_udiff()}.
 */
it('can diff using a callback', function () {
    $compare_func = function ($value_1, $value_2) {
        // 2 is always different.
        if ($value_1 === $value_2 && !in_array(2, [$value_1, $value_2], true)) {
            return 0;
        }

        return 1;
    };
    $iterator_1 = new ArrayIterator([1, 2, 3]);
    $iterator_2 = new ArrayIterator([2, 3, 4]);

    $result = iterator_udiff($iterator_1, $iterator_2, $compare_func);
    expect(iterator_to_array($result))->toBe([1, 2]);
});
