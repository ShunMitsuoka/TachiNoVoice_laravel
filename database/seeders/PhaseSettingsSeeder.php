<?php

namespace Database\Seeders;

use App\Models\PhaseSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhaseSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PhaseSetting::truncate();
        for ($i=1; $i <= 40; $i++) { 
            PhaseSetting::create([
                'phase_id' => $i,
                'end_flg' => false,
                'by_manual_flg' => true,
                'by_limit_flg' => true,
                'by_date_flg' => false,
                'by_instant_flg' => true,
            ]);
            PhaseSetting::create([
                'phase_id' => $i,
                'end_flg' => true,
                'by_manual_flg' => true,
                'by_limit_flg' => true,
                'by_date_flg' => false,
                'by_instant_flg' => false,
            ]);
        }

    }
}
