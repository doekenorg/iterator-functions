<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns a single column for the iteration array / object.
 * @since $ver$
 */
class ColumnIterator extends \IteratorIterator
{
    /**
     * The column to return.
     * @since $ver$
     * @var string|int|null
     */
    private $column_key;

    /**
     * The column to use as a key.
     * @since $ver$
     * @var string|int|null
     */
    private $index_key;

    /**
     * Creates the iterator.
     * @since $ver$
     * @param \Traversable $iterator The iterator that provides the arrays / objects.
     * @param string|int|null $column_key The column to return.
     * @param string|int|null $index_key The key to return.
     */
    public function __construct(\Traversable $iterator, $column_key, $index_key = null)
    {
        parent::__construct($iterator);

        $this->column_key = $column_key;
        $this->index_key = $index_key;
    }

    public function key()
    {
        if (isset($this->index_key)) {
            return $this->column($this->index_key);
        }

        return parent::key();
    }

    /**
     * @inheritdoc
     * @since $ver$
     */
    public function current()
    {
        if (isset($this->column_key)) {
            return $this->column($this->column_key);
        }

        return parent::current();
    }

    protected function column($key)
    {
        $iteration = parent::current();
        if (is_array($iteration) || $iteration instanceof \ArrayAccess) {
            return $iteration[$key];
        }

        if (is_object($iteration)) {
            return $iteration->{$key};
        }

        return null;
    }
}
