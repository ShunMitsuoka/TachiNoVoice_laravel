<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo\Category;

use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\Village\VillageOpinionInfo\Policy\Policy;

class Category extends _Entity
{
    private ?CategoryId $id;
    private string $name;
    private ?Policy $policy;

    function __construct(
        ?CategoryId $id,
        string $name,
        ?Policy $policy,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->policy = $policy;
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new CategoryId($id);
    }

    public function name() : string{
        return $this->name;
    }

    public function existsPolicy() : bool{
        return !is_null($this->policy);
    }

    public function policy() : Policy{
        return $this->policy;
    }

}