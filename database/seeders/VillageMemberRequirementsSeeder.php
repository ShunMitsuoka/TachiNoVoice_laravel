<?php

namespace Database\Seeders;

use App\Models\VillageMemberRequirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillageMemberRequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VillageMemberRequirement::truncate();

        for ($i=1; $i <= 40; $i++) { 
            VillageMemberRequirement::create([
                'village_id' => $i,
                'requirement' => 'ビレッジ参加条件'.$i,
            ]);
        }
    }
}
