<?php

namespace DoekeNorg\IteratorFunctions\Tests\Assets;

class Model
{
    public int $id;

    public string $name;

    private array $data;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;

        // Make this model a bit heavier by creating some data
        $this->data = range(1, 100);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
