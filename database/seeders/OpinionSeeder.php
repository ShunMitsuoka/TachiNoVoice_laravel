<?php

namespace Database\Seeders;

use App\Models\Opinion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Opinion::truncate();

        $id = 1;
        Opinion::create([
            'id' => $id,
            'village_id' => 2,
            'user_id' => 2,
            'opinion' => 'それも良いさ',
        ]);
        $id++;
        Opinion::create([
            'id' => $id,
            'village_id' => 2,
            'user_id' => 3,
            'opinion' => 'さよなら',
        ]);
        $id++;
        Opinion::create([
            'id' => $id,
            'village_id' => 2,
            'user_id' => 4,
            'opinion' => '例えば',
        ]);
        $id++;
        Opinion::create([
            'id' => $id,
            'village_id' => 2,
            'user_id' => 5,
            'opinion' => 'きみがしわせで',
        ]);
        $id++;
        Opinion::create([
            'id' => $id,
            'village_id' => 2,
            'user_id' => 6,
            'opinion' => 'だらっと',
        ]);
        $id++;
    }
}
