<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        $id = 1;
        Category::create([
            'id' => $id,
            'village_id' => 2,
            'category_name' => 'カテゴリーテスト1',
        ]);
        $id++;
        Category::create([
            'id' => $id,
            'village_id' => 2,
            'category_name' => 'カテゴリーテスト2',
        ]);
        $id++;
        Category::create([
            'id' => $id,
            'village_id' => 2,
            'category_name' => 'カテゴリーテスト3',
        ]);
        $id++;
    }
}
