<?php

namespace Database\Seeders;

use App\Models\VillageMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Packages\Domain\Models\User\Member;

class VillageMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VillageMember::truncate();

        // ビレッジ1
        for ($i=1; $i <= 15; $i++) { 
            if($i == 1){
                continue;
            }
            VillageMember::create([
                'user_id' => $i,
                'village_id' => 1,
                'role_id' => Member::ROLE_VILLAGE_MEMBER,
            ]);
        }

        // ビレッジ2
        for ($i=1; $i <= 15; $i++) { 
            if($i == 1){
                continue;
            }
            VillageMember::create([
                'user_id' => $i,
                'village_id' => 2,
                'role_id' => Member::ROLE_VILLAGE_MEMBER,
            ]);
        }

        // ビレッジ3
        for ($i=1; $i <= 15; $i++) { 
            if($i == 1){
                continue;
            }
            VillageMember::create([
                'user_id' => $i,
                'village_id' => 3,
                'role_id' => Member::ROLE_VILLAGE_MEMBER,
            ]);
        }

        // ビレッジ4
        for ($i=1; $i <= 15; $i++) { 
            if($i == 1){
                continue;
            }
            VillageMember::create([
                'user_id' => $i,
                'village_id' => 4,
                'role_id' => Member::ROLE_VILLAGE_MEMBER,
            ]);
        }
    }
}
