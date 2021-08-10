<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that flips the key and the value of the current iteration.
 * @since $ver$
 */
class FlipIterator extends \IteratorIterator
{
    /**
     * @inheritdoc
     * @since $ver$
     */
    public function key()
    {
        return parent::current();
    }

    /**
     * @inheritdoc
     * @since $ver$
     */
    public function current()
    {
        return parent::key();
    }
}
