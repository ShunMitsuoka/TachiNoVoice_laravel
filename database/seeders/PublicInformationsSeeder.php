<?php

namespace Database\Seeders;

use App\Models\PublicInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicInformationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PublicInformation::truncate();

        for ($i=1; $i <= 40; $i++) { 
            PublicInformation::create([
                'village_id' => $i,
                'nickname_flg' => true,
                'gender_flg' => true,
                'age_flg' => true,
            ]);
        }
    }
}
