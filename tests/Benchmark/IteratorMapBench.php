<?php

namespace DoekeNorg\IteratorFunctions\Tests\Benchmark;

use DoekeNorg\IteratorFunctions\Tests\Assets\Model;

/**
 * Benchmark for {@see iterator_map()}.
 */
class IteratorMapBench
{
    protected function getData(): array
    {
        $data = [];
        for ($i = 1; $i <= 1000; $i++) {
            $data[] = ['id' => $i, 'name' => 'name ' . $i];
        }

        return $data;
    }

    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchArrayMap()
    {
        $data = $this->getData();
        $iterator = array_map([$this, 'map'], $data);
        foreach ($iterator as $model) {
            $model->getName();
        }
    }

    /**
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchIteratorMap()
    {
        $data = $this->getData();
        $iterator = iterator_map([$this, 'map'], $data);
        foreach ($iterator as $model) {
            $model->getName();
        }
    }

    public function map(array $user): Model
    {
        return new Model($user['id'], $user['name']);
    }
}
