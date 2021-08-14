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