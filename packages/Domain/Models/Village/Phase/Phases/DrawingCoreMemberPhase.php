<?php
namespace Packages\Domain\Models\Village\Phase\Phases;

use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseSetting;

class DrawingCoreMemberPhase extends VillagePhase
{
    function __construct(
        ?VillagePhaseId $id,
        int $phase_no,
        int $phase_status,
        ?VillagePhaseSetting $phase_start_setting,
        ?VillagePhaseSetting $phase_end_setting,
    ) {
        if($phase_no !== self::PHASE_DRAWING_CORE_MEMBER){
            throw new \Exception("異なるフェーズが設定されました。", 1);
        }
        $this->id = $id;
        $this->phase_no = $phase_no;
        $this->phase_name = self::PHASE_DRAWING_CORE_MEMBER_NAME;
        $this->phase_status = $phase_status;
        $this->phase_start_setting = $phase_start_setting;
        $this->phase_end_setting = $phase_end_setting;
    }

    public function isNecessaryToSetPhaseSetting() : bool{
        return false;
    }
    public function isNecessaryToSetPhaseStartSetting() : bool{
        return false;
    }
    public function isNecessaryToSetPhaseEndSetting() : bool{
        return false;
    }
}