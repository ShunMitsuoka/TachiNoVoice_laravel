<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

interface HostRepositoryInterface 
{
    public function get(int $user_id) : Host;
    public function save(Member $member, Village $village) : Host;
}