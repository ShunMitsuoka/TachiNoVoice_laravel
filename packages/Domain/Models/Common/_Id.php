<?php
namespace Packages\Domain\Models\Common;

class _Id
{
    readonly int $id;

    function __construct(int $id) {
        $this->id = $id;
    }

    public function toInt() : int{
        return $this->id;
    }
}