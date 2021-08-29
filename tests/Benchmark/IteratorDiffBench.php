<?php

namespace DoekeNorg\IteratorFunctions\Tests\Benchmark;

/**
 * Benchmark for {@see iterator_diff()}.
 */
class IteratorDiffBench
{
    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchArrayDiff()
    {
        $iterator = array_diff(range(0, 100), range(20, 100));
        foreach ($iterator as $integer) {
            assert($integer < 20);
        }
    }

    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchIteratorDiff()
    {
        $iterator = iterator_diff(
            new \ArrayIterator(range(0, 100)),
            new \ArrayIterator(range(20, 100))
        );
        foreach ($iterator as $integer) {
            assert($integer < 20);
        }
    }
}
