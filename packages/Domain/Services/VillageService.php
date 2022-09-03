<?php
namespace Packages\Domain\Services;

use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageMemberInfoRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Phase\VillagePhase;
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

    /**
     * ビレッジのフェーズを開始する。
     */
    public function startPhase(Village $village) : Village
    {
        try {
            DB::beginTransaction();
            // 現在のフェーズを開始する。
            $village->phase()->startPhase();
            // 自動で進めるフェーズの場合の処理
            if($village->phase()->phaseNo() == VillagePhase::PHASE_DRAWING_CORE_MEMBER){
                $this->drawingMember($village);
                $village->phase()->completePhase();
                $this->village_repository->update($village);
                $village->nextPhase();
            }
            $updated_village = $this->village_repository->update($village);
            DB::commit();
            return $updated_village;
        } catch (\Throwable $th) {
            logs()->error($th->getMessage());
            DB::rollback();
        }
    }

    /**
     * ビレッジのフェーズを次フェーズに進める。
     */
    public function nextPhase(Village $village) : Village
    {
        try {
            DB::beginTransaction();
            // 現在のフェーズ状態を完了として一度、保存する。
            $village->phase()->completePhase();
            $this->village_repository->update($village);
            // 次フェーズに進める。
            switch ($village->phase()->phaseNo()) {
                case VillagePhase::PHASE_CATEGORIZE_OPINIONS:
                    $village->nextPhase(VillagePhase::PHASE_STATUS_IN_PROGRESS);
                    break;
                default:
                    $village->nextPhase();
                    break;
            }
            $updated_village = $this->village_repository->update($village);
            DB::commit();
            return $updated_village;
        } catch (\Throwable $th) {
            logs()->error($th->getMessage());
            DB::rollback();
        }
    }

    /**
     * メンバー抽選を行う。
     */
    public function drawingMember(Village $village) : Village{
        $village->setMemberInfo($this);
        $village_member_info = $village->memberInfo();
        $village_members = $village_member_info->villageMembers();
        $core_member_limit = $village->setting()->coreMemberLimit();
        if(count($village_members) <= $core_member_limit){
            throw new \Exception("メンバー数が少ないため抽選ができません。", 1);
        }
        $core_member_keys = array_rand($village_members, $core_member_limit);
        $member_info = new VillageMemberInfo(
            $village->id(),
            $village_member_info->hosts(),
            [],
            [],
            []
        );
        foreach ($village_members as $key => $members) {
            if(in_array($key, $core_member_keys)){
                $member_info->addCoreMember($members);
            }else{
                $member_info->addRiseMember($members);
            }
        }
        $this->village_member_info_repository->update($village->id(), $member_info);
        $village->setMemberInfo($this);
        return $village;
    }
}