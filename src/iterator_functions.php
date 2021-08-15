<?php

use DoekeNorg\IteratorFunctions\Iterator\ColumnIterator;
use DoekeNorg\IteratorFunctions\Iterator\DiffIterator;
use DoekeNorg\IteratorFunctions\Iterator\FlipIterator;
use DoekeNorg\IteratorFunctions\Iterator\IntersectIterator;
use DoekeNorg\IteratorFunctions\Iterator\KeysIterator;
use DoekeNorg\IteratorFunctions\Iterator\MapIterator;
use DoekeNorg\IteratorFunctions\Iterator\ValuesIterator;

if (!function_exists('iterator_column')) {
    /**
     * Maps the iteration to a single column from inner object / array.
     * @param \Traversable $iterator The iterator that provides the arrays / objects.
     * @param string|int|null $column_key The column to return.
     * @param string|int|null $index_key The key to return.
     */
    function iterator_column(\Traversable $iterator, $column_key, $index_key = null): ColumnIterator
    {
        return new ColumnIterator($iterator, $column_key, $index_key);
    }
}

if (!function_exists('iterator_diff')) {
    /**
     * Computes the difference of iterators.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_diff(\Iterator $iterator, \Iterator ...$iterators): DiffIterator
    {
        return new DiffIterator($iterator, ...$iterators);
    }
}

if (!function_exists('iterator_diff_assoc')) {
    /**
     * Computes the difference of iterators with extra key check.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_diff_assoc(\Iterator $iterator, \Iterator ...$iterators): DiffIterator
    {
        return (new DiffIterator($iterator, ...$iterators))->withAssociative();
    }
}

if (!function_exists('iterator_diff_key')) {
    /**
     * Computes the difference of iterators by key check.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_diff_key(\Iterator $iterator, \Iterator ...$iterators): DiffIterator
    {
        return (new DiffIterator($iterator, ...$iterators))->withKey();
    }
}

if (!function_exists('iterator_diff_uassoc')) {
    /**
     * Computes the difference of iterators by key check using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable $callback The callback that computes the difference on the keys. Must return an `int`.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_diff_uassoc(): DiffIterator
    {
        [$iterator, $iterators, $callbacks] = DiffIterator::extractParams(func_get_args());

        return (new DiffIterator($iterator, ...$iterators))->withAssociative(...$callbacks);
    }
}

if (!function_exists('iterator_diff_ukey')) {
    /**
     * Computes the difference of iterators by key check using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable $callback The callback that computes the difference on the keys. Must return an `int`.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_diff_ukey(): DiffIterator
    {
        [$iterator, $iterators, $callbacks] = DiffIterator::extractParams(func_get_args());

        return (new DiffIterator($iterator, ...$iterators))->withKey(...$callbacks);
    }
}

if (!function_exists('iterator_udiff')) {
    /**
     * Computes the difference of iterators using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current_value, mixed $compare_value):int The callback to perform.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_udiff(): DiffIterator
    {
        [$iterator, $iterators, $callbacks] = DiffIterator::extractParams(func_get_args());

        return (new DiffIterator($iterator, ...$iterators))->withCallback(...$callbacks);
    }
}

if (!function_exists('iterator_udiff_assoc')) {
    /**
     * Computes the difference of iterators using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current_value, mixed $compare_value):int The callback to perform.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_udiff_assoc(): DiffIterator
    {
        [$iterator, $iterators, $callbacks] = DiffIterator::extractParams(func_get_args());

        return (new DiffIterator($iterator, ...$iterators))
            ->withCallback(...$callbacks)
            ->withAssociative();
    }
}

if (!function_exists('iterator_udiff_uassoc')) {
    /**
     * Computes the difference of iterators using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current_value, mixed $compare_value):int The callback to perform.
     * @param callable(mixed $current_key, mixed $compare_key):int The callback to perform.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_udiff_uassoc(): DiffIterator
    {
        [$iterator, $iterators, $callbacks] = DiffIterator::extractParams(func_get_args());

        return (new DiffIterator($iterator, ...$iterators))
            ->withCallback($callbacks[0])
            ->withAssociative($callbacks[1]);
    }
}

if (!function_exists('iterator_filter')) {
    /**
     * Filters elements off an iterator using a callback function.
     * @param Iterator $iterator The iterator to be filtered.
     * @param callable|null $callback The callback, which should return TRUE to accept the current item or FALSE otherwise.
     * Can be any valid callable value. Will filter empty values by default.
     * The callback should accept up to three arguments: the current item, the current key and the iterator, respectively.
     * @return \CallbackFilterIterator
     * @link https://secure.php.net/manual/en/callbackfilteriterator.construct.php
     */
    function iterator_filter(Iterator $iterator, ?callable $callback = null): \CallbackFilterIterator
    {
        return new \CallbackFilterIterator($iterator, $callback ?? static fn($value): bool => !empty($value));
    }
}

if (!function_exists('iterator_flip')) {
    /**
     * Flips the key and value of an iteration.
     * @param Iterator $iterator The iterator to flip.
     * @return FlipIterator Iterator with flipped values and keys.
     */
    function iterator_flip(Iterator $iterator): FlipIterator
    {
        return new FlipIterator($iterator);
    }
}

if (!function_exists('iterator_intersect')) {
    /**
     * Computes the difference between iterators.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @return IntersectIterator An iterator with the intersection.
     */
    function iterator_intersect(\Iterator $iterator, \Iterator ...$iterators): IntersectIterator
    {
        return new IntersectIterator($iterator, ...$iterators);
    }
}

if (!function_exists('iterator_intersect_assoc')) {
    /**
     * Computes the difference between iterators with extra key check.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @return IntersectIterator An iterator with the intersection.
     */
    function iterator_intersect_assoc(\Iterator $iterator, \Iterator ...$iterators): IntersectIterator
    {
        return (new IntersectIterator($iterator, ...$iterators))->withAssociative();
    }
}
if (!function_exists('iterator_intersect_key')) {
    /**
     * Computes the intersection of iterators by key check.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @return DiffIterator An iterator with the difference.
     */
    function iterator_intersect_key(\Iterator $iterator, \Iterator ...$iterators): DiffIterator
    {
        return (new IntersectIterator($iterator, ...$iterators))->withKey();
    }
}

if (!function_exists('iterator_intersect_uassoc')) {
    /**
     * Computes the difference between iterators with extra key check.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current, mixed $compare):int $callback The callback to use for comparing.
     * @return IntersectIterator An iterator with the intersection.
     */
    function iterator_intersect_uassoc(): IntersectIterator
    {
        [$iterator, $iterators, $callbacks] = IntersectIterator::extractParams(func_get_args());

        return (new IntersectIterator($iterator, ...$iterators))->withAssociative(...$callbacks);
    }
}

if (!function_exists('iterator_intersect_ukey')) {
    /**
     * Computes the intersection of iterators by key check using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current, mixed $compare):int $callback The callback to use for comparing.
     * @return IntersectIterator An iterator with the intersection.
     */
    function iterator_intersect_ukey(): IntersectIterator
    {
        [$iterator, $iterators, $callbacks] = IntersectIterator::extractParams(func_get_args());

        return (new IntersectIterator($iterator, ...$iterators))->withKey(...$callbacks);
    }
}

if (!function_exists('iterator_uintersect')) {
    /**
     * Computes the intersection of iterators using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current_value, mixed $compare_value):int The callback to perform.
     * @return IntersectIterator An iterator with the intersection.
     */
    function iterator_uintersect(): IntersectIterator
    {
        [$iterator, $iterators, $callbacks] = IntersectIterator::extractParams(func_get_args());

        return (new IntersectIterator($iterator, ...$iterators))->withCallback(...$callbacks);
    }
}

if (!function_exists('iterator_uintersect_assoc')) {
    /**
     * Computes the intersection of iterators using a callback.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current_value, mixed $compare_value):int The callback to perform.
     * @return IntersectIterator An iterator with the intersection.
     */
    function iterator_uintersect_assoc(): IntersectIterator
    {
        [$iterator, $iterators, $callbacks] = IntersectIterator::extractParams(func_get_args());

        return (new IntersectIterator($iterator, ...$iterators))
            ->withCallback(...$callbacks)
            ->withAssociative();
    }
}

if (!function_exists('iterator_uintersect_uassoc')) {
    /**
     * Computes the intersection of iterators using a callback on the value and the key.
     * @param \Iterator $iterator The iterator to compare from.
     * @param \Iterator ...$iterators The iterators to compare against.
     * @param callable(mixed $current_value, mixed $compare_value):int The callable to perform on the value.
     * @param callable(mixed $current_key, mixed $compare_key):int The callback to perform on the key.
     * @return IntersectIterator An iterator with the difference.
     */
    function iterator_uintersect_uassoc(): IntersectIterator
    {
        [$iterator, $iterators, $callbacks] = IntersectIterator::extractParams(func_get_args());

        return (new IntersectIterator($iterator, ...$iterators))
            ->withCallback($callbacks[0])
            ->withAssociative($callbacks[1]);
    }
}

if (!function_exists('iterator_keys')) {
    /**
     * Returns an iterator that produces only the keys of the inner iterator.
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
     * @param callable $callback Callback function to run for each element in each iterator.
     * @param array|\Iterator ...$iterators Any iterator to apply the callback on.
     * @return MapIterator Iterator that returns the mapped values.
     */
    function iterator_map(callable $callback, iterable ...$iterators): MapIterator
    {
        return new MapIterator($callback, ...$iterators);
    }
}

if (!function_exists('iterator_reduce')) {
    /**
     * Iteratively reduce the iterator to a single value using a callback function.
     * @param Iterator $iterator The input iterator.
     * @param callable $callback The callback, which should return the reduced value. It takes three arguments:
     *   - mixed $carry Holds the return value of the previous iteration; in the case of the first iteration it instead holds the value of $initial.
     *   - mixed $value Holds the value of the current iteration.
     *   - mixed $key Holds the key of the current iteration.
     * @param null $initial If the optional initial is available, it will be used at the beginning of the process, or as a final result in case the array is empty.
     * @return mixed The resulting value.
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
     * @param Iterator $iterator The iterator to get the keys from.
     * @return ValuesIterator Iterator that produces the values.
     */
    function iterator_values(\Iterator $iterator): ValuesIterator
    {
        return new ValuesIterator($iterator);
    }
}

if (!function_exists('iterator_walk')) {
    /**
     * Traverses an iterator and applies a callback to every iteration.
     * @param Iterator $iterator The iteration to traverse.
     * @param callable $callback The callback to call for every iteration.
     * @param mixed ...$arguments Any extra arguments to provide to the callback.
     */
    function iterator_walk(\Iterator $iterator, callable $callback, ...$arguments): void
    {
        foreach ($iterator as $key => $value) {
            $callback($value, $key, ...$arguments);
        }
    }
}
