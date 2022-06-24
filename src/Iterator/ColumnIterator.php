<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that returns a single column for the iteration array / object.
 */
class ColumnIterator implements \IteratorAggregate
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
     * The internal key count.
     * @var int
     */
    private int $count = 0;

    /**
     * The inner iterator.
     * @var \Traversable
     */
    private \Traversable $iterator;

    /**
     * Creates the iterator.
     * @param \Traversable $iterator The iterator that provides the arrays / objects.
     * @param string|int|null $column_key The column to return.
     * @param string|int|null $index_key The key to return.
     */
    public function __construct(\Traversable $iterator, $column_key, $index_key = null)
    {
        $this->iterator = $iterator;
        $this->column_key = $column_key;
        $this->index_key = $index_key;
    }

    /**
     * Retrieves a single column from the current iteration.
     * @param array|\ArrayAccess|object $iteration The iteration.
     * @param int|string $key The key to retrieve from the iteration.
     * @return mixed|null The value.
     */
    private function getColumn($iteration, $key)
    {
        if (is_array($iteration) || $iteration instanceof \ArrayAccess) {
            return $iteration[$key] ?? null;
        }

        if (is_object($iteration)) {
            return $iteration->{$key} ?? null;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): \Generator
    {
        foreach ($this->iterator as $key => $iteration) {
            if (isset($this->index_key)) {
                $key = $this->getColumn($iteration, $this->index_key) ?? $this->count++;
            }

            if (isset($this->column_key)) {
                $iteration = $this->getColumn($iteration, $this->column_key);
                if ($iteration === null) {
                    continue;
                }
            }

            yield $key => $iteration;
        }
    }
}
