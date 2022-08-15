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
use Packages\Domain\Models\User\UserInfo\Gender;

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
            'gender' => Gender::GENDER_MAN,
            'date_of_birth' => new Carbon('1996/04/14'),
        ]);

        ModelsUser::create([
            'email' => 'test1@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => '二階堂ふみ',
            'nickname' => '二階堂ふみ',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1996/04/14'),
        ]);

        ModelsUser::factory(20)->create();
    }
}
