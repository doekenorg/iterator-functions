<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that applies a callback to the elements of the given iterators.
 */
class MapIterator implements \IteratorAggregate
{
    /**
     * Callback function to run for each element in each iterator.
     * @var callable
     */
    private $callback;

    /**
     * The inner iterator.
     * @var \MultipleIterator
     */
    private \MultipleIterator $iterator;

    /**
     * Returns the iterator.
     * @param array|\Iterator ...$iterators Any iterator to apply the callback on. Can also be an array.
     * @param callable $callback Callback function to run for each element in each iterator.
     */
    public function __construct(callable $callback, iterable ...$iterators)
    {
        try {
            $function = new \ReflectionFunction(\Closure::fromCallable($callback));
        } catch (\ReflectionException $e) {
            throw new \RuntimeException($e->getMessage(), (int)$e->getCode(), $e);
        }

        if (!$function->isVariadic() && $function->getNumberOfParameters() !== count($iterators)) {
            throw new \InvalidArgumentException('The callback needs as many arguments as provided iterators.');
        }

        $this->iterator = new \MultipleIterator();
        foreach ($iterators as $iterator) {
            if (is_array($iterator)) {
                $iterator = new \ArrayIterator($iterator);
            }
            $this->iterator->attachIterator($iterator);
        }

        $this->callback = $callback;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \Generator
    {
        foreach ($this->iterator as $key => $value) {
            yield $key[0] => ($this->callback)(...$value);
        }
    }
}
