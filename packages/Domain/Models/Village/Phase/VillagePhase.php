<?php
namespace Packages\Domain\Models\Village\Phase;

use Packages\Domain\Interfaces\Models\Village\Phase\VillagePhaseInterface;
use Packages\Domain\Models\Common\_Entity;

abstract class VillagePhase extends _Entity implements VillagePhaseInterface
{
    /**
     * フェーズ1:ビレッジメンバー募集
     */
    public const PHASE_RECRUITMENT_OF_MEMBER = 1;
    public const PHASE_RECRUITMENT_OF_MEMBER_NAME = 'ビレッジメンバー募集';
    /**
     * フェーズ2:メンバー抽選
     */
    public const PHASE_DRAWING_CORE_MEMBER = 2;
    public const PHASE_DRAWING_CORE_MEMBER_NAME = 'メンバー抽選';

    /**
     * フェーズ3:コアメンバー意見募集
     */
    public const PHASE_ASKING_OPINIONS_OF_CORE_MEMBER = 3;
    public const PHASE_ASKING_OPINIONS_OF_CORE_MEMBER_NAME = 'コアメンバー意見募集';

    /**
     * フェーズ4:意見カテゴリー分け
     */
    public const PHASE_CATEGORIZE_OPINIONS  = 4;
    public const PHASE_CATEGORIZE_OPINIONS_NAME = '意見カテゴリー分け';

    /**
     * フェーズ5:ライズメンバー意見募集
     */
    public const PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER  = 5;
    public const PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER_NAME = 'ライズメンバー意見募集';

    /**
     * フェーズ6:意見評価フェーズ
     */
    public const PHASE_EVALUATION  = 6;
    public const PHASE_EVALUATION_NAME = '意見評価';

    /**
     * フェーズ7:方針決定
     */
    public const PHASE_DECIDING_POLICY  = 7;
    public const PHASE_DECIDING_POLICY_NAME = '方針決定';

    /**
     * フェーズ8:満足度調査
     */
    public const PHASE_SURVEYING_SATISFACTION  = 8;
    public const PHASE_SURVEYING_SATISFACTION_NAME = '満足度調査';

    /**
     * ステータス：準備中
     */
    public const PHASE_STATUS_PREPARATION = 1;
    public const PHASE_STATUS_PREPARATION_NAME = '準備中';
    /**
     * ステータス：進行中
     */
    public const PHASE_STATUS_IN_PROGRESS = 100;
    public const PHASE_STATUS_IN_PROGRESS_NAME = '進行中';

    /**
     * ステータス：完了
     */
    public const PHASE_STATUS_COMPLATE = 200;
    public const PHASE_STATUS_COMPLATE_NAME = '完了';

    protected ?VillagePhaseId $id;
    protected int $phase_no;
    protected string $phase_name;
    protected int $phase_status;
    protected ?VillagePhaseStartSetting $phase_start_setting;
    protected ?VillagePhaseEndSetting $phase_end_setting;

    protected StartSettingInfo $start_setting_info;
    protected EndSettingInfo $end_setting_info;

    function __construct(
        ?VillagePhaseId $id,
        int $phase_no,
        int $phase_status,
        ?VillagePhaseStartSetting $phase_start_setting = null,
        ?VillagePhaseEndSetting $phase_end_setting = null,
    ) {
        $this->id = $id;
        $this->phase_no = $phase_no;
        $this->phase_status = $phase_status;
        $this->phase_start_setting = $phase_start_setting;
        $this->phase_end_setting = $phase_end_setting;
    }

    public function setId(int $id){
        if(!is_null($this->id)){
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new VillagePhaseId($id);
    }

    public function phaseNo() : int{
        return $this->phase_no;
    }

    public function phaseName() : string{
        return $this->phase_name;
    }

    public function phaseStatus() : int{
        return $this->phase_status;
    }

    public function existsPhaseSetting() : bool{
        return !is_null($this->phase_start_setting) || !is_null($this->phase_end_setting);
    }

    public function existsPhaseStartSetting() : bool{
        return !is_null($this->phase_start_setting);
    }

    public function existsPhaseEndSetting() : bool{
        return !is_null($this->phase_end_setting);
    }
    
    public function phaseStartSetting() : ?VillagePhaseStartSetting{
        return $this->phase_start_setting;
    }

    public function phaseEndSetting() : ?VillagePhaseEndSetting{
        return $this->phase_end_setting;
    }

    public function startSettingInfo() : ?StartSettingInfo{
        return $this->start_setting_info;
    }

    public function endSettingInfo() : ?EndSettingInfo{
        return $this->end_setting_info;
    }

    public function updatePhaseStartSetting(VillagePhaseStartSetting $phase_start_setting){
        $this->phase_start_setting = $phase_start_setting;
    }

    public function updatePhaseEndSetting(VillagePhaseEndSetting $phase_end_setting){
        $this->phase_end_setting = $phase_end_setting;
    }


    public function isReady() : bool{
        return $this->phase_status == self::PHASE_STATUS_PREPARATION;
    }

    public function getPhaseStatusName():string{
        switch ($this->phase_status) {
            case self::PHASE_STATUS_PREPARATION:
                return self::PHASE_STATUS_PREPARATION_NAME;
            case self::PHASE_STATUS_IN_PROGRESS:
                return self::PHASE_STATUS_IN_PROGRESS_NAME;
            case self::PHASE_STATUS_COMPLATE:
                return self::PHASE_STATUS_COMPLATE_NAME;
            default:
                throw new \Exception("存在しないPhaseStatusです。", 1);
                break;
        }
    }

    public function completePhase(){
        $this->phase_status = self::PHASE_STATUS_COMPLATE;
    }

    public function startPhase(){
        $this->phase_status = self::PHASE_STATUS_IN_PROGRESS;
    }

    public function isPhaseAskingOpinionsOfCoreMember() : bool{
        return $this->phase_no == self::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER;
    }

    public function isPhaseAskingOpinionOfRizeMenber() : bool{
        return $this->phase_no == self::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER;
    }

    public function isPhaseCategorizeOpinions() : bool{
        return $this->phase_no == self::PHASE_CATEGORIZE_OPINIONS;
    }

    public function isPhaseEvaluation() : bool {
        return $this->phase_no == self::PHASE_EVALUATION;
    }

    public function isPhaseDicidingPolicy() : bool {
        return $this->phase_no == self::PHASE_DECIDING_POLICY;
    }

    public function isPhaseSurveyingSatisfaction() : bool {
        return $this->phase_no == self::PHASE_SURVEYING_SATISFACTION;
    }

    public function isLastPhase() : bool{
        return $this->phase_no == self::PHASE_SURVEYING_SATISFACTION;
    }

    protected function getStartSetting(?VillagePhaseStartSetting $phase_start_setting) : VillagePhaseStartSetting{
        if(!is_null($phase_start_setting)){
            return $phase_start_setting;
        }
        return VillagePhaseStartSetting::defaultSetting();
    }

    protected function getEndSetting(?VillagePhaseEndSetting $phase_end_setting) : VillagePhaseEndSetting{
        if(!is_null($phase_end_setting)){
            return $phase_end_setting;
        }
        return VillagePhaseEndSetting::defaultSetting();
    }
}
