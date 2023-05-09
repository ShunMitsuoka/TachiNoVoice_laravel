<?php
namespace Packages\Domain\Models\Village\Phase\Phases;

use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseSetting;

class CategorizeOpinionsPhase extends VillagePhase
{
    protected bool $is_necessary_to_set_phase_start_setting = false;
    protected bool $is_necessary_to_set_phase_end_setting = false;

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
}