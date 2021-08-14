<?php

/**
 * Tests for {@see iterator_diff_assoc()}.
 */
it('diffs two iterators associatively', function () {
    $iterator_1 = new ArrayIterator(['a' => 'green', 'b' => 'brown', 'c' => 'blue', 'red']);
    $iterator_2 = new ArrayIterator(['a' => 'green', 'yellow', 'red']);

    $result = iterator_diff_assoc($iterator_1, $iterator_2);

    expect(iterator_to_array($result))->toBe(['b' => 'brown', 'c' => 'blue', 0 => 'red']);
});
