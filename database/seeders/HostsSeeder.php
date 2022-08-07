<?php

namespace Database\Seeders;

use App\Models\Host;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Host::truncate();

        Host::create([
            'user_id' => 1,
            'village_id' => 1,
        ]);

        Host::create([
            'user_id' => 1,
            'village_id' => 2,
        ]);

        Host::create([
            'user_id' => 1,
            'village_id' => 3,
        ]);

        Host::create([
            'user_id' => 1,
            'village_id' => 4,
        ]);
    }
}
