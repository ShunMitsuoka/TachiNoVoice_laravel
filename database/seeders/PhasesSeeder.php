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
        Phase::create([
            'id' => 1,
            'village_id' => 1,
            'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_PREPARATION,
        ]);
        // ビレッジ2
        Phase::create([
            'id' => 2,
            'village_id' => 2,
            'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_IN_PROGRESS,
        ]);
        // ビレッジ3
        Phase::create([
            'id' => 3,
            'village_id' => 3,
            'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_COMPLATE,
        ]);
        Phase::create([
            'id' => 4,
            'village_id' => 3,
            'm_phase_id' => VillagePhase::PHASE_DRAWING_CORE_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_PREPARATION,
        ]);
        // ビレッジ4
        Phase::create([
            'id' => 5,
            'village_id' => 4,
            'm_phase_id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_COMPLATE,
        ]);
        Phase::create([
            'id' => 6,
            'village_id' => 4,
            'm_phase_id' => VillagePhase::PHASE_DRAWING_CORE_MEMBER,
            'm_phase_status_id' => VillagePhase::PHASE_STATUS_IN_PROGRESS,
        ]);
    }
}
