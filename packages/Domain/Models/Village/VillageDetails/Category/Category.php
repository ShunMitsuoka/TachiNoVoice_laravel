<?php

namespace Packages\Domain\Models\Village\VillageDetails\Category;

use Package\Domain\Models\Village\VillageDetais\Policy\Policy;
use Packages\Domain\Models\Common\_Entity;



class Category extends _Entity
{

    public const UNCATEGORIZED_ID = 0;
    public const UNCATEGORIZED_LABEL = 'カテゴリー未分類';

    protected ?CategoryId $id;
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

    static public function uncategorizedCategory() : self{
        return new self(
            new CategoryId(self::UNCATEGORIZED_ID),
            self::UNCATEGORIZED_LABEL,
            null,
        );
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new CategoryId($id);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function existsPolicy(): bool
    {
        return !is_null($this->policy);
    }

    public function policy(): Policy
    {
        return $this->policy;
    }

    public function isUncategorizedCategory() : bool{
        return $this->id()->toInt() == self::UNCATEGORIZED_ID;
    }
}
