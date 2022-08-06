<?php
namespace Packages\Domain\Models\Common;

class _Entity
{
    public function id() : _Id
    {
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id;
    }

    public function setId(int $id){
        if(!is_null($this->id)){
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new _Id($id);
    }
}