<?php

namespace Packages\Infrastructure\Repositories;

use App\Models\User as ModelUser;
use Illuminate\Support\Facades\Hash;
use Packages\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Packages\Domain\Models\User\User;

class UserRepository implements UserRepositoryInterface
{
    public function update(User $user): bool
    {
        if ($user->getPassword() == '') {
            ModelUser::where('id', $user->id()->toInt())
                ->update([
                    'user_name' => $user->name(),
                    'nickname' => $user->nickname(),
                    'gender' => $user->gender()->id(),
                    'email' => $user->email(),
                    'date_of_birth' => $user->dateOfBirth(),
                ]);
        } else {
            ModelUser::where('id', $user->id()->toInt())
                ->update([
                    'user_name' => $user->name(),
                    'nickname' => $user->nickname(),
                    'gender' => $user->gender()->id(),
                    'email' => $user->email(),
                    'date_of_birth' => $user->dateOfBirth(),
                    'password' => Hash::make($user->getPassword())
                ]);
        }

        return true;
    }
}
