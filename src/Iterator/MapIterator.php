<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that applies a callback to the elements of the given iterators. *
 * @since $ver$
 */
class MapIterator extends \IteratorIterator
{
    /**
     * Callback function to run for each element in each iterator.
     * @since $ver$
     * @var callable
     */
    private $callback;

    /**
     * Returns the iterator.
     * @since $ver$
     * @param array|\Iterator ...$iterators Any iterator to apply the callback on. Can also be an array.
     * @param callable $callback Callback function to run for each element in each iterator.
     */
    public function __construct(callable $callback, iterable ...$iterators)
    {
        try {
            $function = new \ReflectionFunction(\Closure::fromCallable($callback));
        } catch (\ReflectionException $e) {
            throw new \RuntimeException($e->getMessage(), (int) $e->getCode(), $e);
        }

        if (!$function->isVariadic() && $function->getNumberOfParameters() !== count($iterators)) {
            throw new \InvalidArgumentException('The callback needs as many arguments as provided iterators.');
        }

        $inner = new \MultipleIterator();
        foreach ($iterators as $iterator) {
            if (is_array($iterator)) {
                $iterator = new \ArrayIterator($iterator);
            }
            $inner->attachIterator($iterator);
        }

        parent::__construct($inner);

        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     * @since $ver$
     */
    public function key()
    {
        $keys = parent::key();

        return is_array($keys) ? reset($keys) : parent::key();
    }

    /**
     * @inheritdoc
     * @since $ver$
     */
    public function current()
    {
        return call_user_func_array($this->callback, parent::current());
    }
}
