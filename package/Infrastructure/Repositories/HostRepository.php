<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\Host as ModelsHost;
use Exception;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\Village\Village;

class HostRepository implements HostRepositoryInterface 
{
    public function get(int $user_id) : Host{
        throw new Exception("Error Processing Request", 1);
    }
    public function save(Member $member, Village $village) : Host{
        $created_host = ModelsHost::create([
            'user_id' => $member->id(),
            'village_id' => $village->id(),
        ]);
        return new Host(
            new MemberId($created_host->id),
            'test',
            'test',
            'test',
            1,
            $created_host->created_at,
            $village,
        );
    }
}