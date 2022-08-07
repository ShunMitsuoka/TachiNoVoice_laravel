<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;

class VillagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Village::truncate();

        for ($i=1; $i <= 40; $i++) { 
            Village::create([
                'id' => $i,
                'title' => 'ビレッジテスト'.$i,
                'content' => 'ビレッジテス'.$i.' 内容',
                'note' => 'ビレッジテスト'.$i.' 注意',
            ]);
        }
    }
}
