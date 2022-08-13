<?php
namespace Packages\Domain\Models\Village\Phase;

class EndSettingInfo
{
    private VillagePhaseSettingItem $by_manual;
    private VillagePhaseSettingItem $by_date;
    private VillagePhaseSettingItem $by_limit;

    function __construct(
        VillagePhaseSettingItem $by_manual,
        VillagePhaseSettingItem $by_date,
        VillagePhaseSettingItem $by_limit,
    ) {
        $this->end_flg = true;
        $this->by_manual = $by_manual;
        $this->by_date = $by_date;
        $this->by_limit = $by_limit;
    }

    public function byManual() : VillagePhaseSettingItem{
        return $this->by_manual;
    }

    public function byDate() : VillagePhaseSettingItem{
        return $this->by_date;
    }

    public function byLimit() : VillagePhaseSettingItem{
        return $this->by_limit;
    }
}