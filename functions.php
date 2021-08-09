<?php

use DoekeNorg\IteratorFunctions\Iterator\MapIterator;

if (!function_exists('iterator_map')) {
    /**
     * Returns an iterator that applies a callback to each value.
     * @since $ver$
     * @param callable $callback
     * @param Iterator ...$iterators
     * @return MapIterator
     */
    function iterator_map(callable $callback, Iterator ...$iterators): MapIterator
    {
        return new MapIterator($callback, ...$iterators);
    }
}
