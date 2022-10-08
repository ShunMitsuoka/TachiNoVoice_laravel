<?php

namespace Packages\Domain\Models\Village\VillageDetails\Opinion;

use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;

class Opinion extends _Entity
{
    protected ?OpinionId $id;
    private string $content;
    private ?CategoryId $category_id;

    function __construct(
        ?OpinionId $id,
        string $content,
        ?CategoryId $category_id = null,
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->category_id = $category_id;
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new OpinionId($id);
    }

    public function content(): string
    {
        return $this->content;
    }

    public function categoryId(): ?categoryId
    {
        return $this->category_id;
    }

    public function existsCategoryId() : bool{
        return !is_null($this->category_id);
    }

    public function setCategoryId(?CategoryId $category_id)
    {
        $this->category_id = $category_id;
    }
}
