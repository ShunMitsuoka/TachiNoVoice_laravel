<?php

namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\VillageMember;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Topic\Topic;
use Packages\Domain\Models\Village\VillageDetails\Category\Category;
use Packages\Domain\Services\Casts\CategoryCast;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillagePhaseService;
use Packages\Domain\Services\VillageService;

class Village extends _Entity
{
    protected ?VillageId $id;
    protected VillagePhase $phase;
    protected VillageSetting $setting;
    protected Topic $topic;
    protected VillageMemberRequirement $requirement;
    protected VillagePublicInformation $public_information;
    protected ?VillageMemberInfo $member_info;

    function __construct(
        ?VillageId $id,
        VillagePhase $phase,
        Topic $topic,
        VillageSetting $setting,
        VillageMemberRequirement $requirement,
        VillagePublicInformation $public_information,
        ?VillageMemberInfo $member_info = null
    ) {
        $this->id = $id;
        $this->phase = $phase;
        $this->topic = $topic;
        $this->setting = $setting;
        $this->requirement = $requirement;
        $this->public_information = $public_information;
        $this->member_info = $member_info;
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new VillageId($id);
    }

    public function phase(): VillagePhase
    {
        return $this->phase;
    }
    public function topic(): Topic
    {
        return $this->topic;
    }
    public function categories(): array
    {
        $categories = $this->topic()->categories();
        if(count($categories) > 0){
            $category = CategoryCast::castCategory($categories[0]);
            if(!$category->isUncategorizedCategory() && 
                ( $this->phase()->isPhaseAskingOpinionsOfCoreMember() || $this->phase()->isPhaseCategorizeOpinions()))
            {
                array_unshift($categories, Category::uncategorizedCategory());
            }
        }else{
            array_unshift($categories, Category::uncategorizedCategory());
        }
        return $categories;
    }

    public function setting(): VillageSetting
    {
        return $this->setting;
    }
    public function requirement(): VillageMemberRequirement
    {
        return $this->requirement;
    }
    public function publicInformation(): VillagePublicInformation
    {
        return $this->public_information;
    }
    public function existsMemberInfo(): bool
    {
        return !is_null($this->member_info);
    }

    public function memberInfo(): VillageMemberInfo
    {
        if (is_null($this->member_info)) {
            throw new \Exception('メンバー情報が存在しません。');
        }
        return $this->member_info;
    }

    public function getMemberDetails(Member $member) : ?VillageMember{
        if (is_null($this->member_info)) {
            throw new \Exception('メンバー情報が存在しません。');
        }
        if($this->member_info->isCoreMember($member)){
            $members = $this->member_info->coreMembers();
            return $members[$member->id()->toInt()];
        }
        if($this->member_info->isRiseMember($member)){
            $members = $this->member_info->riseMembers();
            return $members[$member->id()->toInt()];
        }
        throw new \Exception('メンバー情報が存在しません。');
    }

    public function setMemberInfo(VillageService $service)
    {
        $this->member_info = $service->getVillageMemberInfo($this);
    }

    public function setDetailsInfo(VillageDetailsService $service)
    {
        // $service->get($this);
    }

    public function getMemberRole(Member $member): int
    {
        if (is_null($this->member_info)) {
            throw new \Exception('メンバー情報が存在しません。');
        }
        switch (true) {
            case $this->memberInfo()->isHost($member);
                return Member::ROLE_HOST;
            case $this->memberInfo()->isVillageMember($member);
                return Member::ROLE_VILLAGE_MEMBER;
            case $this->memberInfo()->isCoreMember($member);
                return Member::ROLE_CORE_MEMBER;
            case $this->memberInfo()->isRiseMember($member);
                return Member::ROLE_RISE_MEMBER;
            default:
                break;
        }
        throw new \Exception('メンバーに役割が設定されていません。');
    }

    /**
     * 現在のフェーズを次のフェーズに進める
     */
    public function nextPhase()
    {

        $next_phase = $this->phase->phaseNo();
        $phase_status = VillagePhase::PHASE_STATUS_PREPARATION;
        switch ($this->phase->phaseNo()) {
            case VillagePhase::PHASE_RECRUITMENT_OF_MEMBER:
                $next_phase = VillagePhase::PHASE_DRAWING_CORE_MEMBER;
                break;
            case VillagePhase::PHASE_DRAWING_CORE_MEMBER:
                $next_phase = VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER;
                break;
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                $next_phase = VillagePhase::PHASE_CATEGORIZE_OPINIONS;
                $phase_status = VillagePhase::PHASE_STATUS_IN_PROGRESS;
                break;
            case VillagePhase::PHASE_CATEGORIZE_OPINIONS:
                $next_phase = VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER;
                break;
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                $next_phase = VillagePhase::PHASE_EVALUATION;
                break;
            case VillagePhase::PHASE_EVALUATION:
                $next_phase = VillagePhase::PHASE_DECIDING_POLICY;
                $phase_status = VillagePhase::PHASE_STATUS_IN_PROGRESS;
                break;
            case VillagePhase::PHASE_DECIDING_POLICY:
                $next_phase = VillagePhase::PHASE_SURVEYING_SATISFACTION;
                break;
            case VillagePhase::PHASE_SURVEYING_SATISFACTION:
                // 満足度調査は最終フェーズのため次へは行かない
                throw new \Exception('満足度調査は最終フェーズのため次フェーズは存在しません');
            default:
                throw new \Exception('存在しないフェーズが設定されています。');
        }
        $this->phase = VillagePhaseService::getVillagePhase(
            null,
            $next_phase,
            $phase_status,
            null,
            null
        );
    }
}
