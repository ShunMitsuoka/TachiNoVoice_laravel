<?php
namespace Packages\Domain\Models\Collections;

class BaseCollection
{
    protected array $items;
    protected array $info;

    public function __construct(
        array $items = [],
        array $info = [],
    )
    {
        $this->items = $items;
        $this->info = $info;
    }

    public function items() : array{
        return $this->items;
    }

    public function info() : array{
        return $this->info;
    }
}