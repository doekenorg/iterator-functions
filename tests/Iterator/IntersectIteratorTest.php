<?php

use \DoekeNorg\IteratorFunctions\Iterator\DiffIterator;
use DoekeNorg\IteratorFunctions\Iterator\IntersectIterator;

/**
 * Tests for {@see DiffIterator}.
 *
 * Other features are tested through `iterator_diff` functions.
 */

it('can intersect', function () {
    $iterator_1 = new ArrayIterator(['one', 'two']);
    $iterator_2 = new ArrayIterator(['one']);
    $result = iterator_to_array(new IntersectIterator($iterator_1, $iterator_2));

    expect($result)->toBe([0 => 'one']);
});
