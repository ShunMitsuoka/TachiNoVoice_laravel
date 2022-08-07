<?php

namespace Database\Seeders;

use App\Models\Phase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Packages\Domain\Models\Village\Phase\VillagePhase;

class PhasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Phase::truncate();

        for ($i=1; $i <= 40; $i++) { 
            Phase::create([
                'village_id' => $i,
                'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
                'm_phase_status_id' => VillagePhase::PHASE_STATUS_PREPARATION,
            ]);
        }
    }
}
