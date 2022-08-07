<?php

namespace Database\Seeders;

use App\Models\MPhase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Packages\Domain\Models\Village\Phase\VillagePhase;

class MPhasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MPhase::truncate();
        MPhase::create([
            'id' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER,
            'phase_name' => VillagePhase::PHASE_RECRUITMENT_OF_MEMBER_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_DRAWING_CORE_MEMBER,
            'phase_name' => VillagePhase::PHASE_DRAWING_CORE_MEMBER_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER,
            'phase_name' => VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_CATEGORIZE_OPINIONS,
            'phase_name' => VillagePhase::PHASE_CATEGORIZE_OPINIONS_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER,
            'phase_name' => VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_EVALUATION,
            'phase_name' => VillagePhase::PHASE_EVALUATION_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_DECIDING_POLICY,
            'phase_name' => VillagePhase::PHASE_DECIDING_POLICY_NAME,
        ]);
        MPhase::create([
            'id' => VillagePhase::PHASE_SURVEYING_SATISFACTION,
            'phase_name' => VillagePhase::PHASE_SURVEYING_SATISFACTION_NAME,
        ]);
    }
}
