<?php

namespace DoekeNorg\IteratorFunctions\Iterator;

/**
 * Iterator that computes the difference between multiple iterators.
 */
class DiffIterator extends \FilterIterator
{
    /**
     * Iterators to compare against.
     * @var \AppendIterator
     */
    private \AppendIterator $iterator_compare;

    /**
     * The value of {@see DiffIterator::accept()} when the values equal.
     * @var bool
     */
    protected bool $equal_accept = false;

    /**
     * Whether the value should be compared including the key.
     * @var bool
     */
    private bool $with_associative = false;

    /**
     * Whether the key should be compared instead of the value.
     * @var bool
     */
    private bool $with_key = false;

    /**
     * @inheritdoc
     * @since $ver$
     */
    public function __construct(\Iterator $iterator, \Iterator ...$iterators)
    {
        parent::__construct($iterator);

        $this->iterator_compare = new \AppendIterator();

        foreach ($iterators as $iterator_compare) {
            $this->iterator_compare->append($iterator_compare);
        }
    }

    /**
     * @inheritdoc
     * @since $ver$
     */
    public function accept(): bool
    {
        if ($this->with_key && $this->with_associative) {
            throw new \InvalidArgumentException('Can only use one of "withKey" or "withAssociative", not both.');
        }

        foreach ($this->iterator_compare as $key => $value) {
            if ($this->with_key && $key === $this->key()) {
                return $this->equal_accept;
            }

            if ($value === $this->current()) {
                if ($this->with_associative && $key !== $this->key()) {
                    continue;
                }

                return $this->equal_accept;
            }
        }

        return !$this->equal_accept;
    }

    /**
     * Sets the iterator whether to compare with an extra key check.
     * @param bool $bool Whether the iterator should be compared with extra key check.
     * @return $this The iterator.
     */
    public function withAssociative(bool $bool): self
    {
        $this->with_associative = $bool;

        return $this;
    }

    /**
     * Sets the iterator whether to compare against the key.
     * @param bool $bool Whether the iterator should be compared against the key.
     * @return $this The iterator.
     */
    public function withKey(bool $bool): self
    {
        $this->with_key = $bool;

        return $this;
    }
}
