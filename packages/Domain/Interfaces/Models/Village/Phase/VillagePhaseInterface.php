<?php

namespace Packages\Domain\Interfaces\Models\Village\Phase;

interface VillagePhaseInterface 
{
    public function isNecessaryToSetPhaseSetting() : bool;
    public function isNecessaryToSetPhaseStartSetting() : bool;
    public function isNecessaryToSetPhaseEndSetting() : bool;
    // public function getStartSettingItem() : array;
    // public function getEndSettingItem() : array;
}