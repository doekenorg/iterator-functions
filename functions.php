<?php

use DoekeNorg\IteratorFunctions\Iterator\KeysIterator;
use DoekeNorg\IteratorFunctions\Iterator\MapIterator;
use DoekeNorg\IteratorFunctions\Iterator\ValuesIterator;

if (!function_exists('iterator_filter')) {
    /**
     * Filters elements off an iterator using a callback function.
     * @since $ver$
     * @param Iterator $iterator The iterator to be filtered.
     * @param callable|null $callback The callback, which should return TRUE to accept the current item or FALSE otherwise.
     * Can be any valid callable value. Will filter empty values by default.
     * The callback should accept up to three arguments: the current item, the current key and the iterator, respectively.
     * @return \CallbackFilterIterator
     * @link https://secure.php.net/manual/en/callbackfilteriterator.construct.php
     */
    function iterator_filter(Iterator $iterator, ?callable $callback = null): \CallbackFilterIterator
    {
        return new \CallbackFilterIterator($iterator, $callback ?? static fn($value) => !empty($value));
    }
}

if (!function_exists('iterator_keys')) {
    /**
     * Returns an iterator that produces only the keys of the inner iterator.
     * @since $ver$
     * @param Iterator $iterator The iterator to get the keys from.
     * @return KeysIterator Iterator that produces the keys.
     */
    function iterator_keys(\Iterator $iterator): KeysIterator
    {
        return new KeysIterator($iterator);
    }
}

if (!function_exists('iterator_map')) {
    /**
     * Applies the callback to the elements of the given iterators.
     * @since $ver$
     * @param callable $callback Callback function to run for each element in each iterator.
     * @param Iterator ...$iterators Any iterator to apply the callback on.
     * @return MapIterator Iterator that returns the mapped values.
     */
    function iterator_map(callable $callback, Iterator ...$iterators): MapIterator
    {
        return new MapIterator($callback, ...$iterators);
    }
}

if (!function_exists('iterator_reduce')) {
    /**
     * Iteratively reduce the iterator to a single value using a callback function.
     * @since $ver$
     * @param Iterator $iterator The input iterator.
     * @param callable $callback The callback, which should return the reduced value. It takes three arguments:
     *   - mixed $carry Holds the return value of the previous iteration; in the case of the first iteration it instead holds the value of $initial.
     *   - mixed $value Holds the value of the current iteration.
     *   - mixed $key Holds the key of the current iteration.
     * @param null $initial If the optional initial is available, it will be used at the beginning of the process, or as a final result in case the array is empty.
     * @return mixed|null The resulting value.
     */
    function iterator_reduce(\Iterator $iterator, callable $callback, $initial = null)
    {
        foreach ($iterator as $key => $value) {
            $initial = $callback($initial, $value, $key);
        }

        return $initial;
    }
}

if (!function_exists('iterator_values')) {
    /**
     * Returns an iterator that produces only the values of the inner iterator.
     * @since $ver$
     * @param Iterator $iterator The iterator to get the keys from.
     * @return KeysIterator Iterator that produces the values.
     */
    function iterator_values(\Iterator $iterator): ValuesIterator
    {
        return new ValuesIterator($iterator);
    }
}
