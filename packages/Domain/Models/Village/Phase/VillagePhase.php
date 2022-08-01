<?php
namespace Packages\Domain\Models\Village\Phase;

class VillagePhase
{
    private ?VillagePhaseId $id;
    private int $phase;
    private int $phase_status;
    private VillagePhaseSetting $phase_start_setting;
    private VillagePhaseSetting $phase_end_setting;

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
    public const PHASE_STATUS_READY = 1;
    public const PHASE_STATUS_READY_NAME = '準備中';
    /**
     * ステータス：進行中
     */
    public const PHASE_STATUS_IN_PROGRESS = 100;
    public const PHASE_STATUS_IN_PROGRESS_NAME = '進行中';

    /**
     * ステータス：完了
     */
    public const PHASE_STATUS_COMPLATE = 999;
    public const PHASE_STATUS_COMPLATE_NAME = '完了';

    function __construct(
        ?VillagePhaseId $id,
        int $phase,
        int $phase_status,
        ?VillagePhaseSetting $phase_start_setting,
        ?VillagePhaseSetting $phase_end_setting,
    ) {
        $this->id = $id;
        $this->phase = $phase;
        $this->phase_status = $phase_status;
        $this->phase_start_setting = $phase_start_setting;
        $this->phase_end_setting = $phase_end_setting;
    }

    public function id() : VillagePhaseId
    {
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id;
    }

    public function phase() : int{
        return $this->phase;
    }

    public function phaseStatus() : int{
        return $this->phase_status;
    }

    public function existsPhaseStartSetting() : bool{
        return !is_null($this->phase_start_setting);
    }

    public function existsPhaseEndSetting() : bool{
        return !is_null($this->phase_end_setting);
    }
    
    
    public function phaseStartSetting() : ?VillagePhaseSetting{
        return $this->phase_start_setting;
    }

    public function phaseEndSetting() : ?VillagePhaseSetting{
        return $this->phase_end_setting;
    }

    /**
     * ビレッジ初期フェーズ作成
     */
    static function getInitPhase(
        VillagePhaseSetting $phase_start_setting,
        VillagePhaseSetting $phase_end_setting,
    ) : self{
        return new self(
            null,
            self::PHASE_RECRUITMENT_OF_MEMBER, 
            self::PHASE_STATUS_READY,
            $phase_start_setting,
            $phase_end_setting,
        );
    }

    public function getPhaseName():string{
        switch ($this->phase) {
            case self::PHASE_RECRUITMENT_OF_MEMBER:
                return self::PHASE_RECRUITMENT_OF_MEMBER_NAME;
            case self::PHASE_DRAWING_CORE_MEMBER:
                return self::PHASE_DRAWING_CORE_MEMBER_NAME;
            case self::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                return self::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER_NAME;
            case self::PHASE_CATEGORIZE_OPINIONS:
                return self::PHASE_CATEGORIZE_OPINIONS_NAME;
            case self::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                return self::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER_NAME;
            case self::PHASE_EVALUATION:
                return self::PHASE_EVALUATION_NAME;
            case self::PHASE_DECIDING_POLICY:
                return self::PHASE_DECIDING_POLICY_NAME;
            case self::PHASE_SURVEYING_SATISFACTION:
                return self::PHASE_SURVEYING_SATISFACTION_NAME;
            default:
                throw new \Exception("存在しないPhaseです。", 1);
                break;
        }
    }

    public function getPhaseStatusName():string{
        switch ($this->phase_status) {
            case self::PHASE_STATUS_READY:
                return self::PHASE_STATUS_READY_NAME;
            case self::PHASE_STATUS_IN_PROGRESS:
                return self::PHASE_STATUS_IN_PROGRESS_NAME;
            case self::PHASE_STATUS_COMPLATE:
                return self::PHASE_STATUS_COMPLATE_NAME;
            default:
                throw new \Exception("存在しないPhaseStatusです。", 1);
                break;
        }
    }

}