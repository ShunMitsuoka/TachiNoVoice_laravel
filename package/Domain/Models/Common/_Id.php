<?php
namespace Packages\Domain\Models\Common;

class _Id
{
    protected int $id;

    function __construct(int $id) {
        $this->id = $id;
    }

    public function id() : int{
        return $this->id;
    }
}