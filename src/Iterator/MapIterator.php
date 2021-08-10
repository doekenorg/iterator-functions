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
     * @param callable $callback Callback function to run for each element in each iterator.
     * @param \Iterator ...$iterators Any iterator to apply the callback on.
     * @since $ver$
     * @throws \ReflectionException When the callback could not be reflected.
     */
    public function __construct(callable $callback, \Iterator ...$iterators)
    {
        $function = new \ReflectionFunction($callback);
        if (!$function->isVariadic() && $function->getNumberOfParameters() !== count($iterators)) {
            throw new \InvalidArgumentException('The callback needs as many arguments as provided iterators.');
        }

        $inner = new \MultipleIterator();
        foreach ($iterators as $iterator) {
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