<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns only the keys of the provided iterator.
 */
class KeysIterator extends ValuesIterator
{
    /**
     * @inheritdoc
     * @psalm-suppress UndefinedInterfaceMethod Psalm doesn't understand the inner iterator is an {@see \Iterator}.
     */
    public function current()
    {
        return $this->getInnerIterator()->key();
    }
}
