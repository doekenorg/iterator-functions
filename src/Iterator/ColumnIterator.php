<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns a single column for the iteration array / object.
 */
class ColumnIterator extends \IteratorIterator
{
    /**
     * The column to return.
     * @var string|int|null
     */
    private $column_key;

    /**
     * The column to use as a key.
     * @var string|int|null
     */
    private $index_key;

    /**
     * Creates the iterator.
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

    /**
     * @inheritdoc
     */
    public function key()
    {
        if (isset($this->index_key)) {
            return $this->column($this->index_key);
        }

        return parent::key();
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        if (isset($this->column_key)) {
            return $this->column($this->column_key);
        }

        return parent::current();
    }

    /**
     * Retrieves a single column from the current iteration.
     * @param int|string $key The key to retrieve from the iteration.
     * @return mixed|null The value.
     */
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
