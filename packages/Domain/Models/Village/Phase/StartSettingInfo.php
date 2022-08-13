<?php
namespace Packages\Domain\Models\Village\Phase;

class StartSettingInfo
{
    private VillagePhaseSettingItem $by_manual;
    private VillagePhaseSettingItem $by_date;
    private VillagePhaseSettingItem $by_instant;

    function __construct(
        VillagePhaseSettingItem $by_manual,
        VillagePhaseSettingItem $by_date,
        VillagePhaseSettingItem $by_instant,
    ) {
        $this->end_flg = false;
        $this->by_manual = $by_manual;
        $this->by_date = $by_date;
        $this->by_instant = $by_instant;
    }

    public function byManual() : VillagePhaseSettingItem{
        return $this->by_manual;
    }

    public function byDate() : VillagePhaseSettingItem{
        return $this->by_date;
    }

    public function byInstant() : VillagePhaseSettingItem{
        return $this->by_instant;
    }
}