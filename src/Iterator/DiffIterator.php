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
     * Callback to use for _assoc comparing.
     * @var null|callable
     */
    private $assoc_compare;

    /**
     * Callback to use for key comparison.
     * @var null|callable
     */
    private $key_compare;

    /**
     * callback to use for value comparison.
     * @var null|callable
     */
    private $value_compare;

    /**
     * @inheritdoc
     */
    public function __construct(\Iterator $iterator, \Iterator ...$iterators)
    {
        parent::__construct($iterator);

        $this->iterator_compare = new \AppendIterator();
        $this->value_compare = self::defaultCompare();

        foreach ($iterators as $iterator_compare) {
            $this->iterator_compare->append($iterator_compare);
        }
    }

    /**
     * Extracts the params from a function call.
     * @param array $arguments The provided arguments.
     * @return mixed The params.
     */
    public static function extractParams(array $arguments): array
    {
        $result = ['iterator' => null, 'iterators' => [], 'callbacks' => []];

        $iterator = array_shift($arguments);
        if (!$iterator instanceof \Iterator) {
            throw new \InvalidArgumentException('First parameter must be an iterator.');
        }

        $result['iterator'] = $iterator;

        while (($argument = array_shift($arguments))) {
            if (!$argument instanceof \Iterator && !is_callable($argument)) {
                throw new \InvalidArgumentException(sprintf(
                    'Argument should be an iterator or callback; "%s" given.',
                    is_string($argument) ? $argument : get_class($argument),
                ));
            }
            $type = $argument instanceof \Iterator
                ? 'iterators'
                : 'callbacks';
            $result[$type][] = $argument;
        }

        return array_values($result);
    }

    /**
     * @inheritdoc
     */
    public function accept(): bool
    {
        if ($this->key_compare && $this->assoc_compare) {
            throw new \InvalidArgumentException('Can only use one of "withKey" or "withAssociative", not both.');
        }

        foreach ($this->iterator_compare as $key => $value) {
            if ($this->key_compare && ($this->key_compare)($this->key(), $key) === 0) {
                return $this->equal_accept;
            }

            if (($this->value_compare)($this->current(), $value) === 0) {
                if ($this->assoc_compare && (($this->assoc_compare)($this->key(), $key) !== 0)) {
                    continue;
                }

                return $this->equal_accept;
            }
        }

        return !$this->equal_accept;
    }

    /**
     * Sets the iterator whether to compare with an extra key check.
     * @param callable|null $callback Optional callback to use for comparison.
     * @return $this The iterator.
     */
    public function withAssociative(?callable $callback = null): self
    {
        $this->assoc_compare = $callback ?? self::defaultCompare();

        return $this;
    }

    /**
     * Sets the iterator to compare against the key.
     * @param null|callable $callback Optional callable to perform as key compare function.
     * @return $this The iterator.
     */
    public function withKey(?callable $callback = null): self
    {
        $this->key_compare = $callback ?? self::defaultCompare();

        return $this;
    }

    /**
     * Sets the iterator to compare the value by callback.
     * @param callable $callback Callable to perform as compare function.
     * @return $this The iterator.
     */
    public function withCallback(callable $callback): self
    {
        $this->value_compare = $callback;

        return $this;
    }

    /**
     * The default function to use for comparing.
     * @return callable(mixed $current, mixed $compare):int 0 when the same, -1 of 1 when different.
     */
    final protected static function defaultCompare(): callable
    {
        return static fn($current, $compare) => $current <=> $compare;
    }
}
