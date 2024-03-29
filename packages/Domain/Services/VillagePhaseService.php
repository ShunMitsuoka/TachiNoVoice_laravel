<?php
namespace Packages\Domain\Services;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Phase\Phases\AskingOpinionsOfCoreMemberPhase;
use Packages\Domain\Models\Village\Phase\Phases\AskingOpinionsOfRiseMemberPhase;
use Packages\Domain\Models\Village\Phase\Phases\CategorizeOpinionsPhase;
use Packages\Domain\Models\Village\Phase\Phases\DecidingPolicyPhase;
use Packages\Domain\Models\Village\Phase\Phases\DrawingCoreMemberPhase;
use Packages\Domain\Models\Village\Phase\Phases\EvaluationPhase;
use Packages\Domain\Models\Village\Phase\Phases\RecruitmentOfMemberPhase;
use Packages\Domain\Models\Village\Phase\Phases\SurveyingSatisfactionPhase;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseEndSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseStartSetting;
use Packages\Domain\Models\Village\Village;

class VillagePhaseService{

    /**
     * ビレッジ初期フェーズ作成
     */
    static function getInitPhase(
        VillagePhaseStartSetting $phase_start_setting,
        VillagePhaseEndSetting $phase_end_setting,
    ) : VillagePhase{
        $phase_status = $phase_start_setting->byInstantFlg() ? VillagePhase::PHASE_STATUS_IN_PROGRESS : VillagePhase::PHASE_STATUS_PREPARATION;
        return new RecruitmentOfMemberPhase(
            null,
            VillagePhase::PHASE_RECRUITMENT_OF_MEMBER, 
            $phase_status,
            $phase_start_setting,
            $phase_end_setting,
        );
    }

    /**
     * フェーズNoから個別のフェーズを取得する
     */
    static public function getVillagePhase(
        ?VillagePhaseId $id,
        int $phase_no,
        int $phase_status,
        ?VillagePhaseStartSetting $phase_start_setting,
        ?VillagePhaseEndSetting $phase_end_setting,
    ) : VillagePhase{
        switch ($phase_no) {
            case VillagePhase::PHASE_RECRUITMENT_OF_MEMBER:
                return new RecruitmentOfMemberPhase(
                    $id,
                    $phase_no,
                    $phase_status,
                    $phase_start_setting,
                    $phase_end_setting
                );
            case VillagePhase::PHASE_DRAWING_CORE_MEMBER:
                return new DrawingCoreMemberPhase(
                    $id,
                    $phase_no,
                    $phase_status
                );
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                return new AskingOpinionsOfCoreMemberPhase(
                    $id,
                    $phase_no,
                    $phase_status,
                    $phase_end_setting
                );
            case VillagePhase::PHASE_CATEGORIZE_OPINIONS:
                return new CategorizeOpinionsPhase(
                    $id,
                    $phase_no,
                    $phase_status
                );
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                return new AskingOpinionsOfRiseMemberPhase(
                    $id,
                    $phase_no,
                    $phase_status,
                    $phase_end_setting
                );
            case VillagePhase::PHASE_EVALUATION:
                return new EvaluationPhase(
                    $id,
                    $phase_no,
                    $phase_status,
                    $phase_end_setting
                );
            case VillagePhase::PHASE_DECIDING_POLICY:
                return new DecidingPolicyPhase(
                    $id,
                    $phase_no,
                    $phase_status
                );
            case VillagePhase::PHASE_SURVEYING_SATISFACTION:
                return new SurveyingSatisfactionPhase(
                    $id,
                    $phase_no,
                    $phase_status,
                    $phase_end_setting
                );
            default:
                throw new \Exception("存在しないPhaseです。", 1);
                break;
        }
    }

    /**
     * 対象ビレッジの対象ユーザに評価を表示するかどうか判定
     */
    static public function isShowEvaluation(Village $village, Member $member) : bool
    {
        switch ($village->phase()->phaseNo()) {
            
            case VillagePhase::PHASE_EVALUATION:
                if($member->isHost()){
                    return true;
                }
                break;
            case VillagePhase::PHASE_DECIDING_POLICY:
            case VillagePhase::PHASE_SURVEYING_SATISFACTION:
                return true;
            default:
        }
        return false;
    }

    /**
     * 対象ビレッジの対象ユーザが評価可能かどうか判断する
     */
    static public function canEvaluation(Village $village, Member $member) : bool
    {
        if($village->phase()->isReady() || $member->isHost() ){
            return false;
        }
        switch ($village->phase()->phaseNo()) {
            case VillagePhase::PHASE_EVALUATION:
                return true;
            default:
        }
        return false;
    }
}