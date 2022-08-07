<?php

namespace Database\Seeders;

use App\Models\MPhasesStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Packages\Domain\Models\Village\Phase\VillagePhase;

class MPhaseStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MPhasesStatus::truncate();
        MPhasesStatus::create([
            'id' => VillagePhase::PHASE_STATUS_PREPARATION,
            'status_name' => VillagePhase::PHASE_STATUS_PREPARATION_NAME,
        ]);
        MPhasesStatus::create([
            'id' => VillagePhase::PHASE_STATUS_IN_PROGRESS,
            'status_name' => VillagePhase::PHASE_STATUS_IN_PROGRESS_NAME,
        ]);
        MPhasesStatus::create([
            'id' => VillagePhase::PHASE_STATUS_COMPLATE,
            'status_name' => VillagePhase::PHASE_STATUS_COMPLATE_NAME,
        ]);
    }
}
