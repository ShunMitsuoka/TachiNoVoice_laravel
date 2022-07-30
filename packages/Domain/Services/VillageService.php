<?php
namespace Packages\Domain\Services;

use App\Models\Village as ModelsVillage;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageMemberRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

class VillageService{

    protected VillageRepositoryInterface $village_repository;
    protected HostRepositoryInterface $host_repository;
    protected VillageMemberRepositoryInterface $village_member_repository;

    function __construct(
        VillageRepositoryInterface $village_repository,
        HostRepositoryInterface $host_repository,
        VillageMemberRepositoryInterface $village_member_repository,
    ) {
        $this->village_repository = $village_repository;
        $this->host_repository = $host_repository;
        $this->village_member_repository = $village_member_repository;
    }

    public function villageRepository() : VillageRepositoryInterface{
        return $this->village_repository;
    }
    public function hostRepository() : HostRepositoryInterface{
        return $this->host_repository;
    }
    public function villageMemberRepository() : VillageMemberRepositoryInterface{
        return $this->village_member_repository;
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
            $this->host_repository->save($register_member, $registered_village);
            DB::commit();
            return $registered_village;
        } catch (\Throwable $th) {
            DB::rollback();
            logs()->error($th->getMessage());
        }
        return null;
    }

    /**
     * ビレッジにメンバーを設定する
     */
    public function setVillageMember(Village $village) : Village{
        $hosts = $this->host_repository->getAllByVillageId($village->id());
        foreach ($hosts as $host) {
            $village->addHost($host);
        }
        $village_members = $this->village_member_repository->getAllByVillageId($village->id());
        foreach ($village_members as $village_member) {
            switch (true) {
                case $village_member->isVillageMember():
                    $village->addVillageMember($village_member);
                    break;
                case $village_member->isCoreMember():
                    $village->addCoreMember($village_member);
                    break;
                case $village_member->isRiseMember():
                    $village->addRiseMember($village_member);
                    break;
                default:
                    break;
            }
        }
        return $village;
    }

    /**
     * ビレッジに参加する
     */
    public function joinVillage(VillageId $village_id, Member $member) : ?Village{
        DB::beginTransaction();
        try {
            $village_member = 
            $registered_village = $this->village_member_repository->save($village_id, $village_member);
            // $this->host_repository->save($register_member, $registered_village);
            DB::commit();
            return $registered_village;
        } catch (\Throwable $th) {
            DB::rollback();
            logs()->error($th->getMessage());
        }
        return null;
    }
}