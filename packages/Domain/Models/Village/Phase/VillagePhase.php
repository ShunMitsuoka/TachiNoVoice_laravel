<?php
namespace Packages\Domain\Models\Village\Phase;

use Carbon\Carbon;

class VillagePhase
{
    private VillagePhaseId $id;
    private int $phase;
    private int $phase_status;
    private VillagePhaseSetting $phase_setting;

    /**
     * フェーズ1:ビレッジメンバー募集
     */
    public const PHASE_RECRUITMENT_OF_MEMBER = 1;

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
        VillagePhaseSetting $phase_setting,
    ) {
        $this->id = $id;
        $this->phase = $phase;
        $this->phase_status = $phase_status;
        $this->phase_setting = $phase_setting;
    }

    public function id() : int
    {
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id->id();
    }

    public function phase() : int{
        return $this->phase;
    }

    public function phaseStatus() : int{
        return $this->phase_status;
    }
    
    public function phaseSetting() : VillagePhaseSetting{
        return $this->phase_setting;
    }

    public function isEndPhase() : bool{
        return $this->phase_setting->isEndPhase();
    }

    public function byManual() : bool{
        return $this->phase_setting->byManual();
    }

    public function byLimit() : bool{
        return $this->phase_setting->byLimit();
    }

    public function byDate() : bool{
        return $this->phase_setting->byDate();
    }
    public function borderDate() : Carbon{
        return $this->phase_setting->borderDate();
    }

    /**
     * ビレッジ初期フェーズ作成
     */
    static function getInitPhase(
        bool $by_manual_flg,
        bool $by_limit_flg,
        bool $by_date_flg,
        bool $by_instant_flg,
        ?Carbon $border_date,
    ) : self{
        return new self(
            null,
            self::PHASE_RECRUITMENT_OF_MEMBER, 
            self::PHASE_STATUS_READY,
            new VillagePhaseSetting(false, $by_manual_flg, $by_limit_flg, $by_date_flg, $by_instant_flg, $border_date)
        );
    }
}