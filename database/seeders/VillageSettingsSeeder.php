<?php

namespace Database\Seeders;

use App\Models\VillageSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VillageSetting::truncate();

        for ($i=1; $i <= 40; $i++) { 
            VillageSetting::create([
                'village_id' => $i,
                'village_member_limit' => 15,
                'core_member_limit' => 5,
            ]);
        }
    }
}
