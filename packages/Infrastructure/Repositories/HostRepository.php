<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\Host as ModelsHost;
use Carbon\Carbon;
use Exception;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\Village;

class HostRepository implements HostRepositoryInterface 
{
    public function get(int $user_id) : Host{
        throw new Exception("Error Processing Request", 1);
    }
    public function save(Member $member, Village $village) : bool{
        ModelsHost::create([
            'user_id' => $member->id()->toInt(),
            'village_id' => $village->id()->toInt(),
        ]);
        return true;
    }
    public function getAllByVillageId(int $village_id) : array{
        $result = [];
        $records = ModelsHost::from('hosts as hosts')
            ->select(
                'user_id',
                'email',
                'user_name',
                'nickname',
                'gender',
                'date_of_birth',
            )
            ->join('users', 'users.id', 'hosts.user_id')
            ->where('village_id', $village_id)
            ->get();
        foreach ($records as $record) {
            $result[] = new Host(
                new UserId($record->user_id),
                $record->user_name,
                $record->nickname,
                $record->email,
                $record->gender,
                new Carbon($record->date_of_birth),
            );
        }
        return $result;
    }
}