<?php
namespace Packages\Domain\Models\Common;

abstract class _Entity
{
    public function id() : _Id
    {
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id;
    }

    public function existsId() : bool
    {
        return !is_null($this->id);
    }

    abstract public function setId(int $id);
}