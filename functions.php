<?php

use DoekeNorg\IteratorFunctions\Iterator\MapIterator;

if (!function_exists('iterator_filter')) {
    /**
     * Filters elements off an iterator using a callback function.
     * @since $ver$
     * @param Iterator $iterator The iterator to be filtered.
     * @param callable|null $callback The callback, which should return TRUE to accept the current item or FALSE otherwise.
     * Can be any valid callable value. Will filter empty values by default.
     * The callback should accept up to three arguments: the current item, the current key and the iterator, respectively.
     * @link https://secure.php.net/manual/en/callbackfilteriterator.construct.php
     * @return \CallbackFilterIterator
     */
    function iterator_filter(Iterator $iterator, ?callable $callback = null): \CallbackFilterIterator
    {
        return new \CallbackFilterIterator($iterator, $callback ?? static fn($value) => !empty($value));
    }
}


if (!function_exists('iterator_map')) {
    /**
     * Applies the callback to the elements of the given iterators.
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
