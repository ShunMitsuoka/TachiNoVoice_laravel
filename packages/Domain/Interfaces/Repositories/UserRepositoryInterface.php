<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\User;

interface UserRepositoryInterface
{
    public function update(User $user): bool;
}
