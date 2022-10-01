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
            $role_Member = Member::ROLE_RISE_MEMBER;
            if(in_array($i, [2,3,4,5,6])){
                $role_Member = Member::ROLE_CORE_MEMBER;
            }
            VillageMember::create([
                'user_id' => $i,
                'village_id' => 2,
                'role_id' => $role_Member,
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
