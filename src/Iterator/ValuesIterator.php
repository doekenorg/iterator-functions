<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns only the values of the provided iterator.
 */
class ValuesIterator implements \IteratorAggregate
{
    /**
     * The inner iterator.
     * @var \Traversable
     */
    private \Traversable $iterator;

    /**
     * Creates the iterator.
     * @param \Traversable $iterator The inner iterator.
     */
    public function __construct(\Traversable $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \Generator
    {
        foreach ($this->iterator as $value) {
            yield $value;
        }
    }
}
