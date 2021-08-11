<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns only the values of the provided iterator.
 */
class ValuesIterator extends \IteratorIterator
{
    /**
     * The internal key count.
     * @var int
     */
    private int $count = 0;

    /**
     * @inheritdoc
     */
    public function key(): int
    {
        return $this->count;
    }

    /**
     * @inheritdoc
     *
     * Increases the internal count.
     *
     */
    public function next(): void
    {
        parent::next();
        ++$this->count;
    }

    /**
     * @inheritdoc
     *
     * Resets the internal count.
     *
     */
    public function rewind(): void
    {
        parent::rewind();

        $this->count = 0;
    }
}
