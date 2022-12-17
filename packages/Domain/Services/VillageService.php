<?php
namespace Packages\Domain\Services;

use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageMemberInfoRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Interfaces\Services\SendNextPhaseEmailServiceInterface;
use Packages\Domain\Interfaces\Services\TextMiningServiceInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberInfo;
use Packages\Domain\Services\Casts\MemberCast;
use Packages\Domain\Services\Casts\OpinionCast;

class VillageService{

    protected VillageRepositoryInterface $village_repository;
    protected VillageMemberInfoRepositoryInterface $village_member_info_repository;
    protected VillageDetailsService $village_details_service;
    protected TextMiningServiceInterface $text_mining_service;
    protected SendNextPhaseEmailServiceInterface $send_next_phase_email_service;

    function __construct(
        VillageRepositoryInterface $village_repository,
        VillageMemberInfoRepositoryInterface $village_member_info_repository,
        VillageDetailsService $village_details_service,
        TextMiningServiceInterface $text_mining_service,
        SendNextPhaseEmailServiceInterface $send_next_phase_email_service
    ) {
        $this->village_repository = $village_repository;
        $this->village_member_info_repository = $village_member_info_repository;
        $this->village_details_service = $village_details_service;
        $this->text_mining_service = $text_mining_service;
        $this->send_next_phase_email_service = $send_next_phase_email_service;
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
            // テキストマイニングを行う
            $this->villageTextMining($village);
            // 次フェーズに進める。
            switch ($village->phase()->phaseNo()) {
                // 自動でフェーズを進行中に変更
                case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                case VillagePhase::PHASE_EVALUATION:
                    $village->nextPhase(VillagePhase::PHASE_STATUS_IN_PROGRESS);
                    break;
                default:
                    $village->nextPhase();
                    break;
            }
            $updated_village = $this->village_repository->update($village);
            $this->send_next_phase_email_service->sendNextPhaseEmail($updated_village);
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
        if($core_member_limit == 1){
            $core_member_keys = [$core_member_keys];
        }
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

    /**
     * テキストマイニングを行う
     */
    protected function villageTextMining(Village $village){
        // テキストマイニングを行う
        switch ($village->phase()->phaseNo()) {
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                $this->village_details_service->setDetails($village);
                return $this->coreMemberOpinionTextMining($village);
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                $this->village_details_service->setDetails($village);
                return $this->memberOpinionTextMining($village);
            default:
                return;
        }
    }

    /**
     * コアメンバー意見のテキストマイニングを行う
     */
    protected function coreMemberOpinionTextMining(Village $village) :string
    {
        $village_members = $village->memberInfo()->coreMembers();
        // $village_members += $village->memberInfo()->riseMembers();
        $opinion_text = '';
        foreach ($village_members as $member) {
            $core_member = MemberCast::castCoreMember($member);
            $opinions = $core_member->opinions();
            foreach ($opinions as $opinion) {
                $opinion = OpinionCast::castOpinion($opinion);
                $opinion_text .= $opinion->content();
            }
        }
        $path = 'public/village/'.$village->id()->toInt().'/';
        $file_name = 'core_member';
        return $this->text_mining_service->textMining($opinion_text, $path, $file_name);
    }

    /**
     * メンバー意見のテキストマイニングを行う
     */
    protected function memberOpinionTextMining(Village $village)
    {
        $village_members = $village->memberInfo()->coreMembers();
        $village_members += $village->memberInfo()->riseMembers();
        $category_opinions = [];
        foreach ($village_members as $member) {
            $village_member = MemberCast::castVillageMember($member);
            $opinions = $village_member->opinions();
            foreach ($opinions as $opinion) {
                $opinion = OpinionCast::castOpinion($opinion);
                $category_id = $opinion->categoryId()->toInt();

                if(!array_key_exists($category_id, $category_opinions)){
                    $category_opinions[$category_id] = '';
                }
                $category_opinions[$category_id] .= $opinion->content();
            }
        }
        foreach ($category_opinions as $category_id => $text) {
            $path = 'public/village/'.$village->id()->toInt().'/'.$category_id.'/';
            $file_name = 'member_opinion';
            $this->text_mining_service->textMining($text, $path, $file_name);
        }
        return;
    }
}