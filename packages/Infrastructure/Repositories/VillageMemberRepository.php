<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\VillageMember as ModelsVillageMember;
use Carbon\Carbon;
use Packages\Domain\Interfaces\Repositories\VillageMemberRepositoryInterface;
use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\User\VillageMember;
use Packages\Domain\Models\Village\VillageId;

class VillageMemberRepository implements VillageMemberRepositoryInterface
{
    public function getAllByVillageId(int $village_id) : array{
        $result = [];
        $records = ModelsVillageMember::from('village_members as vm')
            ->select(
                'user_id',
                'role_id',
                'email',
                'user_name',
                'nickname',
                'gender',
                'date_of_birth',
            )
            ->join('users', 'users.id', 'vm.user_id')
            ->where('village_id', $village_id)
            ->get();
        foreach ($records as $record) {
            $result[] = new VillageMember(
                new MemberId($record->user_id),
                $record->user_name,
                $record->nickname,
                $record->email,
                $record->gender,
                new Carbon($record->date_of_birth),
                $record->role_id,
            );
        }
        return $result;
    }

    public function save(VillageId $village_id, VillageMember $member): bool{

        ModelsVillageMember::create([
            'user_id' => $member->id()->toInt(),
            'village_id' => $village_id->toInt(),
            'role_id' => $member->role(),
        ]);
        return true;
    }
}