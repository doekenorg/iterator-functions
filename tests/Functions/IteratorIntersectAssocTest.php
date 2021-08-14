<?php
/**
 * Tests for {@see iterator_intersect_assoc()}.
 */

it('intersects two iterators associatively', function () {
    $iterator_1 = new ArrayIterator(['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red']);
    $iterator_2 = new ArrayIterator(['a' => 'green', 'yellow', 'red']);

    $result = iterator_intersect_assoc($iterator_1, $iterator_2);

    expect(iterator_to_array($result))->toBe(['a' => 'green']);
});
