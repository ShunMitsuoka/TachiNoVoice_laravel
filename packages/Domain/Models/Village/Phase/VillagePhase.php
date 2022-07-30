<?php
namespace Packages\Domain\Models\Village\Phase;

use Carbon\Carbon;

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

    /**
     * フェーズ2:メンバー抽選
     */
    public const PHASE_DRAWING_CORE_MEMBER = 2;

    /**
     * フェーズ3:コアメンバー意見募集
     */
    public const PHASE_ASKING_OPINIONS_OF_CORE_MEMBER = 3;

    /**
     * フェーズ4:ホストカテゴリー分け
     */
    public const PHASE_CATEGORIZE_OPINIONS  = 4;

    /**
     * フェーズ5:ライズメンバー意見募集
     */
    public const PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER  = 5;

    /**
     * フェーズ6:評価フェーズ
     */
    public const PHASE_EVALUATION  = 6;

    /**
     * フェーズ7:方針決定
     */
    public const PHASE_DECIDING_POLICY  = 7;

    /**
     * フェーズ8:方針決定
     */
    public const PHASE_SURVEYING_SATISFACTION  = 8;

    /**
     * ステータス：準備中
     */
    public const PHASE_STATUS_READY = 1;
    /**
     * ステータス：進行中
     */
    public const PHASE_STATUS_IN_PROGRESS = 100;
    /**
     * ステータス：完了
     */
    public const PHASE_STATUS_COMPLATE = 999;

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
}