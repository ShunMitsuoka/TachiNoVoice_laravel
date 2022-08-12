<?php
namespace Packages\Domain\Services;

use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageMemberInfoRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberInfo;

class VillageService{

    protected VillageRepositoryInterface $village_repository;
    protected VillageMemberInfoRepositoryInterface $village_member_info_repository;

    function __construct(
        VillageRepositoryInterface $village_repository,
        VillageMemberInfoRepositoryInterface $village_member_info_repository,
    ) {
        $this->village_repository = $village_repository;
        $this->village_member_info_repository = $village_member_info_repository;
    }

    /**
     * idからビレッジを取得する
     */
    public function getVillage(VillageId $village_id) : ?Village{
        try {
            $village_details = $this->village_repository->get($village_id);
            return $village_details;
        } catch (\Throwable $th) {
            logs()->error($th->getMessage());
        }
        return null;
    }

    /**
     * ビレッジを登録する
     */
    public function registerVillage(Member $register_member, Village $village) : ?Village{
        DB::beginTransaction();
        try {
            $registered_village = $this->village_repository->save($village);
            $registered_village->setMemberInfo($this);
            $village_member_info = $registered_village->memberInfo();
            $village_member_info->addHost($register_member);
            $this->village_member_info_repository->update($registered_village->id(), $village_member_info);
            DB::commit();
            return $registered_village;
        } catch (\Throwable $th) {
            DB::rollback();
            logs()->error($th->getMessage());
        }
        return null;
    }

    /**
     * ビレッジのメンバーを情報を取得する
     */
    public function getVillageMemberInfo(Village $village) : VillageMemberInfo{
        return $this->village_member_info_repository->get($village->id());
    }

    /**
     * ビレッジに参加する
     */
    public function joinVillage(VillageId $village_id, Member $member) : bool{
        DB::beginTransaction();
        try {
            $village_member_info = $this->village_member_info_repository->get($village_id);
            $village_member_info->addVillageMember($member);
            $this->village_member_info_repository->update($village_id, $village_member_info);
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            logs()->error($th->getMessage());
        }
        return null;
    }
}