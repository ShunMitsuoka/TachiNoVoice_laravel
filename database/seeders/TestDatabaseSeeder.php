<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // テストデータ
            UsersSeeder::class,
            VillagesSeeder::class,
            VillageMemberRequirementsSeeder::class,
            VillageSettingsSeeder::class,
            PublicInformationsSeeder::class,
            PhasesSeeder::class,
            PhaseSettingsSeeder::class,
            HostsSeeder::class,
            VillageMembersSeeder::class,
            OpinionSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
