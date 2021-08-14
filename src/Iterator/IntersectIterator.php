<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that computes the intersection between multiple iterators.
 */
class IntersectIterator extends DiffIterator
{
    /**
     * @inheritdoc
     */
    protected bool $equal_accept = true;
}
