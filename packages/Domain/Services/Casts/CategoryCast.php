<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Models\Village\VillageDetails\Category\Category;

class CategoryCast{
    static public function castCategory($category) : Category{
        return $category;
    }
}