<?php

namespace Packages\Infrastructure\Repositories;

use Packages\Domain\Interfaces\Repositories\VillageMemberInfoRepositoryInterface;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberInfo;
use App\Models\Host as ModelsHost;
use App\Models\VillageMember as ModelsVillageMember;
use Carbon\Carbon;
use Packages\Domain\Models\User\CoreMember;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\RiseMember;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\User\VillageMember;

class VillageMemberInfoRepository implements VillageMemberInfoRepositoryInterface
{
    public function get(VillageId $village_id) : VillageMemberInfo{
        $hosts = $this->getHosts($village_id);
        $village_members = [];
        $core_members = [];
        $rise_members = [];
        $village_member_records = $this->getVillageMemberRecords($village_id);
        foreach ($village_member_records as $record) {
            switch ($record->role_id) {
                case Member::ROLE_VILLAGE_MEMBER:
                    $village_members[] = new VillageMember(
                        new UserId($record->user_id),
                        $record->user_name,
                        $record->nickname,
                        $record->email,
                        new Gender($record->gender),
                        new Carbon($record->date_of_birth),
                    );
                    break;
                case Member::ROLE_CORE_MEMBER:
                    $core_members[] = new CoreMember(
                        new UserId($record->user_id),
                        $record->user_name,
                        $record->nickname,
                        $record->email,
                        new Gender($record->gender),
                        new Carbon($record->date_of_birth),
                    );
                    break;
                case Member::ROLE_RISE_MEMBER:
                    $rise_members[] = new RiseMember(
                        new UserId($record->user_id),
                        $record->user_name,
                        $record->nickname,
                        $record->email,
                        new Gender($record->gender),
                        new Carbon($record->date_of_birth),
                    );
                    break;
                default:
                    break;
            }
        }
        return new VillageMemberInfo($hosts, $village_members, $core_members, $rise_members);
    }

    public function update(VillageId $village_id, VillageMemberInfo $village_member_info) : bool{
        $hosts = $village_member_info->hosts();
        $village_members = $village_member_info->villageMembers();
        $core_members = $village_member_info->coreMembers();
        $rise_members = $village_member_info->riseMembers();

        foreach ($hosts as $host) {
            ModelsHost::updateOrCreate([
                'village_id' => $village_id->toInt(),
                'user_id' => $host->id()->toInt(),
            ],[
                'village_id' => $village_id->toInt(),
                'user_id' => $host->id()->toInt(),
            ]);
        }

        foreach ($village_members as $village_member) {
            ModelsVillageMember::updateOrCreate([
                'village_id' => $village_id->toInt(),
                'user_id' => $village_member->id()->toInt(),
            ],[
                'village_id' => $village_id->toInt(),
                'user_id' => $village_member->id()->toInt(),
                'role_id' => $village_member->role()
            ]);
        }

        foreach ($core_members as $core_member) {
            ModelsVillageMember::updateOrCreate([
                'village_id' => $village_id->toInt(),
                'user_id' => $core_member->id()->toInt(),
            ],[
                'village_id' => $village_id->toInt(),
                'user_id' => $core_member->id()->toInt(),
                'role_id' => $core_member->role()
            ]);
        }

        foreach ($rise_members as $rise_member) {
            ModelsVillageMember::updateOrCreate([
                'village_id' => $village_id->toInt(),
                'user_id' => $rise_member->id()->toInt(),
            ],[
                'village_id' => $village_id->toInt(),
                'user_id' => $rise_member->id()->toInt(),
                'role_id' => $rise_member->role()
            ]);
        }
        return true;
    }

    private function getVillageMemberRecords(VillageId $village_id){
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
            ->where('village_id', $village_id->toInt())
            ->get();
        return $records;
    }

    private function getHosts(VillageId $village_id) : array{
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
            ->where('village_id', $village_id->toInt())
            ->get();
        foreach ($records as $record) {
            $result[$record->user_id] = new Host(
                new UserId($record->user_id),
                $record->user_name,
                $record->nickname,
                $record->email,
                new Gender($record->gender),
                new Carbon($record->date_of_birth),
            );
        }
        return $result;
    }
}