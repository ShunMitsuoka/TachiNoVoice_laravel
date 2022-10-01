<?php

namespace Database\Seeders;

use App\Models\Opinion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiseOpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=7; $i <= 15; $i++) { 
            Opinion::create([
                'village_id' => 2,
                'user_id' => $i,
                'category_id' => 1,
                'opinion' => 'それも良いさ',
            ]);
        }
        for ($i=7; $i <= 15; $i++) { 
            Opinion::create([
                'village_id' => 2,
                'user_id' => $i,
                'category_id' => 2,
                'opinion' => 'それも良いさ2',
            ]);
        }
        for ($i=7; $i <= 15; $i++) { 
            Opinion::create([
                'village_id' => 2,
                'user_id' => $i,
                'category_id' => 3,
                'opinion' => 'それも良いさ3',
            ]);
        }

    }
}
