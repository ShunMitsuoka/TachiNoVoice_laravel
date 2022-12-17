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
        $update_param = [
            'user_name' => $user->name(),
            'nickname' => $user->nickname(),
            'gender' => $user->gender()->id(),
            'email' => $user->email(),
            'date_of_birth' => $user->dateOfBirth()
        ];
        if ($user->hasPassword()) $update_param['password'] = Hash::make($user->getPassword());
        ModelUser::where('id', $user->id()->toInt())
            ->update($update_param);
        return true;
    }
}
