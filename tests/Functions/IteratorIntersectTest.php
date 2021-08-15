<?php
/**
 * Tests for {@see iterator_intersect()}.
 */

it('intersects two iterators', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3]);
    $iterator_2 = new ArrayIterator([2, 3, 4]);

    $iterator_intersect = iterator_intersect($iterator_1, $iterator_2);
    $iterator_intersect_2 = iterator_intersect($iterator_2, $iterator_1);

    expect(iterator_to_array($iterator_intersect))->toBe([1 => 2, 2 => 3]);
    expect(iterator_to_array($iterator_intersect_2))->toBe([0 => 2, 1 => 3]);
});

it('intersects more than two iterators', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3, 'one', 'two', 'three']);
    $iterator_2 = new ArrayIterator([2, 3, 4]);
    $iterator_3 = new ArrayIterator(['three', 'four', 'five']);

    $iterator_intersect = iterator_intersect($iterator_1, $iterator_2, $iterator_3);

    expect(iterator_to_array($iterator_intersect))->toBe([1 => 2, 2 => 3, 5 => 'three']);
});

/**
 * Tests for {@see iterator_intersect_assoc()}.
 */

it('intersects two iterators associatively', function () {
    $iterator_1 = new ArrayIterator(['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red']);
    $iterator_2 = new ArrayIterator(['a' => 'green', 'yellow', 'red']);

    $result = iterator_intersect_assoc($iterator_1, $iterator_2);

    expect(iterator_to_array($result))->toBe(['a' => 'green']);
});

/**
 * Tests for {@see iterator_intersect_key()}.
 */

it('can intersect by key', function () {
    $iterator_1 = new ArrayIterator(['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4]);
    $iterator_2 = new ArrayIterator(['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8]);

    $result = iterator_intersect_key($iterator_1, $iterator_2);
    expect(iterator_to_array($result))->toBe(['blue' => 1, 'green' => 3]);
});

/**
 * Tests for {@see iterator_intersect_uassoc()}.
 */

it('intersects two iterators associatively with callback', function () {
    $compare_func = function ($key_1, $key_2) {
        if ($key_1 === 'c' && $key_2 === 1) {
            // Red is on 0 in first iterator, and on 1 in second.
            return 0; // Let's consider them the same.
        }

        return $key_1 <=> $key_2;
    };

    $iterator_1 = new ArrayIterator(['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red']);
    $iterator_2 = new ArrayIterator(['a' => 'green', 'yellow', 'blue']);

    $result = iterator_intersect_uassoc($iterator_1, $iterator_2, $compare_func);

    expect(iterator_to_array($result))->toBe(['a' => 'green', 'c' => 'blue']);
});

/**
 * Tests for {@see iterator_intersect_ukey()}.
 */

it('can intersect by key using a callback', function () {
    $compare_func = function ($key_1, $key_2) {
        // green is always different
        if ($key_1 === $key_2 && !in_array('green', [$key_1, $key_2], true)) {
            return 0;
        }

        return 1;
    };
    $iterator_1 = new ArrayIterator(['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4]);
    $iterator_2 = new ArrayIterator(['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan' => 8]);

    $result = iterator_intersect_ukey($iterator_1, $iterator_2, $compare_func);
    expect(iterator_to_array($result))->toBe(['blue' => 1]);
});

it('intersects two iterators using a callback', function () {
    $iterator_1 = new ArrayIterator([1, 2, 3]);
    $iterator_2 = new ArrayIterator([2, 3, 4]);

    $callback = static function ($value_1, $value_2): int {
        // 2 is always different
        if ($value_1 === $value_2 && !in_array(2, [$value_1, $value_2], true)) {
            return 0;
        }

        return 1;
    };

    $iterator_intersect = iterator_uintersect($iterator_1, $iterator_2, $callback);
    $iterator_intersect_2 = iterator_uintersect($iterator_2, $iterator_1, $callback);

    expect(iterator_to_array($iterator_intersect))->toBe([2 => 3]);
    expect(iterator_to_array($iterator_intersect_2))->toBe([1 => 3]);
});
