<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns only the keys of the provided iterator.
 */
class KeysIterator implements \IteratorAggregate
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
        foreach ($this->iterator as $key => $value) {
            yield $key;
        }
    }
}
