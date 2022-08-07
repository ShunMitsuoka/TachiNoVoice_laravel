<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Packages\Domain\Models\User\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsUser::truncate();

        ModelsUser::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => '光岡 駿',
            'nickname' => '光岡 駿',
            'gender' => User::GENDER_MAN,
            'date_of_birth' => new Carbon('1996/04/14'),
        ]);

        ModelsUser::factory(20)->create();
    }
}
