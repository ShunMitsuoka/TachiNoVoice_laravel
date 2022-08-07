<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MPhasesSeeder::class,
            MPhaseStatusesSeeder::class,
            // テストデータ
            UsersSeeder::class,
            VillagesSeeder::class,
            VillageMemberRequirementsSeeder::class,
            VillageSettingsSeeder::class,
            PublicInformationsSeeder::class,
            PhasesSeeder::class,
        ]);
    }
}
