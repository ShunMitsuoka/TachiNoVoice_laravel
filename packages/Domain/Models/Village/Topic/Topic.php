<?php

namespace Packages\Domain\Models\Village\Topic;

use Packages\Domain\Models\Village\VillageDetails\Category\Category;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;
use Packages\Domain\Services\Casts\CategoryCast;

class Topic
{
    private string $title;
    private ?string $content;
    private ?string $note;
    private array $categories;

    function __construct(
        string $title,
        ?string $content,
        ?string $note,
        array $categories = [],
    ) {
        $this->categories = $categories;
        $this->title = $title;
        $this->content = $content;
        $this->note = $note;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function note(): ?string
    {
        return $this->note;
    }

    public function categories(): array
    {
        return $this->categories;
    }
    public function getCategory(CategoryId $category_id): ?Category
    {
        foreach ($this->categories as $category) {
            $category = CategoryCast::castCategory($category);
            if($category->id()->toInt() === $category_id->toInt()){
                return $category;
            }
            # code...
        }
        return null;
    }
    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }
}
