<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Packages\Domain\Models\User\User as MUser;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => Hash::make('test0000'),
            'nickname' => fake()->name(),
            'gender' => fake()->randomElement([MUser::GENDER_MAN, MUser::GENDER_WOMAN, MUser::GENDER_LGBT]),
            'date_of_birth' => fake()->dateTimeBetween('-80 years', '-20years')->format('Y-m-d'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
