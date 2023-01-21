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
        // ビレッジ1
        $id = 1;
        Phase::create([
            'id' => $id,
            'village_id' => 1,
            'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_PREPARATION,
        ]);
        $id++;
        // ビレッジ2
        Phase::create([
            'id' => $id,
            'village_id' => 2,
            'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_COMPLETE,
        ]);
        $id++;
        Phase::create([
            'id' => $id,

            'village_id' => 2,
            'm_phase_id' => VillagePhase::PHASE_DRAWING_CORE_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_COMPLETE,
        ]);
        $id++;
        Phase::create([
            'id' => $id,
            'village_id' => 2,
            'm_phase_id' => VillagePhase::PHASE_DRAWING_CORE_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_COMPLETE,
        ]);
        $id++;
        Phase::create([
            'id' => $id,
            'village_id' => 2,
            'm_phase_id' => VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_IN_PROGRESS,
        ]);
        $id++;
    }
}
