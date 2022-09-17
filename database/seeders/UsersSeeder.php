<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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

        ModelsUser::create([
            'email' => 'test2@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'コアメンバー1',
            'nickname' => 'コアメンバー1',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1998/11/11'),
        ]);

        ModelsUser::create([
            'email' => 'test3@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'コアメンバー2',
            'nickname' => 'コアメンバー2',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1996/11/11'),
        ]);

        ModelsUser::create([
            'email' => 'test4@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'コアメンバー3',
            'nickname' => 'コアメンバー3',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1996/4/14'),
        ]);

        ModelsUser::create([
            'email' => 'test5@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'コアメンバー4',
            'nickname' => 'コアメンバー4',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1996/8/14'),
        ]);

        ModelsUser::create([
            'email' => 'test6@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'ライズメンバー1',
            'nickname' => 'ライズメンバー1',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1998/12/1'),
        ]);

        ModelsUser::create([
            'email' => 'test7@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'ライズメンバー2',
            'nickname' => 'ライズメンバー2',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1998/12/1'),
        ]);

        ModelsUser::factory(20)->create();

        ModelsUser::create([
            'id' => 100,
            'email' => 'test100@gmail.com',
            'password' => Hash::make('test0000'),
            'user_name' => 'ライズメンバー2',
            'nickname' => 'ライズメンバー2',
            'gender' => Gender::GENDER_WOMAN,
            'date_of_birth' => new Carbon('1998/11/11'),
        ]);
    }
}
