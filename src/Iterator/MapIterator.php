<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 *
 *
 * @since $ver$
 */
class MapIterator extends \IteratorIterator
{
    /**
     * The callback to use for every iteration.
     * @since $ver$
     * @var callable
     */
    private $callback;

    /**
     * @inheritdoc
     * @since $ver$
     * @throws \ReflectionException
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
