<?php
namespace Packages\Infrastructure\Repositories;

use Exception;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

class HostRepository implements HostRepositoryInterface 
{
    public function get(int $user_id) : Host{
        throw new Exception("Error Processing Request", 1);
    }
    public function save(Member $member, Village $village) : Host{
        throw new Exception("Error Processing Request", 1);
    }
}