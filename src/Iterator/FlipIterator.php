<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that flips the key and the value of the current iteration.
 */
class FlipIterator extends \IteratorIterator
{
    /**
     * @inheritdoc
     */
    public function key()
    {
        return parent::current();
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return parent::key();
    }
}
