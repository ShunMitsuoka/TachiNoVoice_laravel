<?php
namespace Packages\Domain\Models\Village\Phase\Phases;

use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseSetting;

class CategorizeOpinionsPhase extends VillagePhase
{
    function __construct(
        ?VillagePhaseId $id,
        int $phase_no,
        int $phase_status,
    ) {
        if($phase_no !== self::PHASE_CATEGORIZE_OPINIONS){
            throw new \Exception("異なるフェーズが設定されました。", 1);
        }
        parent::__construct($id, $phase_no, $phase_status);
        $this->phase_name = self::PHASE_CATEGORIZE_OPINIONS_NAME;
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