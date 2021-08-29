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

it('can diff with key validation using a callback', function () {
    $compare_func = function ($key_1, $key_2) {
        if ($key_1 === 0 && $key_2 === 1) {
            // Red is on 0 in first iterator, and on 1 in second.
            return 0; // Let's consider them the same.
        }

        return $key_1 <=> $key_2;
    };

    $iterator_1 = new ArrayIterator(['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red']);
    $iterator_2 = new ArrayIterator(['a' => 'green', 'yellow', 'red']);

    $result = iterator_diff_uassoc($iterator_1, $iterator_2, $compare_func);

    expect(iterator_to_array($result))->toBe(['b' => 'brown', 'c' => 'blue']);
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

/**
 * Test for {@see iterator_udiff_assoc()}.
 */
it('can diff using a callback and a key validation', function () {
    $compare_func = function ($value_1, $value_2) {
        if ($value_1 === 'apple' && $value_2 === 'orange') {
            return 0; // nothing to compare, same fruit
        }

        return $value_1 <=> $value_2;
    };

    $iterator_1 = new ArrayIterator(['apple', 'pear', 'lime']);
    $iterator_2 = new ArrayIterator(['orange', 'berry']);

    $result = iterator_udiff_assoc($iterator_1, $iterator_2, $compare_func);
    expect(iterator_to_array($result))->toBe([1 => 'pear', 2 => 'lime']);
});

/**
 * Test for {@see iterator_udiff_uassoc()}.
 */
it('can diff using a callback and a key validation using a callback', function () {
    $value_compare = function ($value_1, $value_2) {
        if ($value_1 === 'apple' && $value_2 === 'orange') {
            return 0; // nothing to compare, same fruit
        }

        return $value_1 <=> $value_2;
    };

    $key_compare = function ($value_1, $value_2) {
        if ($value_1 === 0 && $value_2 === 1) {
            return 0; // nothing to compare, same fruit
        }

        return $value_1 <=> $value_2;
    };

    $iterator_1 = new ArrayIterator(['apple', 'pear', 'lime']);
    $iterator_2 = new ArrayIterator(['berry', 'orange']);

    $result = iterator_udiff_uassoc($iterator_1, $iterator_2, $value_compare, $key_compare);
    expect(iterator_to_array($result))->toBe([1 => 'pear', 2 => 'lime']);
});

test('exceptions are thrown', function (string $function, string $expected_message, array $args) {
    expect(static fn () => $function(...$args))->toThrow($expected_message);
})
    ->with([
               ['iterator_diff_uassoc', 'No associative callback provided.', [$it = new ArrayIterator(), $it]],
               ['iterator_diff_ukey', 'No key callback provided.', [$it, $it]],
               ['iterator_udiff', 'No diff callback provided.', [$it, $it]],
               ['iterator_udiff_assoc', 'No diff callback provided.', [$it, $it]],
               ['iterator_udiff_uassoc', 'No diff callback provided.', [$it, $it]],
               ['iterator_udiff_uassoc', 'No associative callback provided.', [$it, $it, $callback = fn () => '']],
           ]);