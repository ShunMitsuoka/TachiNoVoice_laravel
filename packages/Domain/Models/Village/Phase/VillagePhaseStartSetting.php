<?php
namespace Packages\Domain\Models\Village\Phase;

use Carbon\Carbon;

class VillagePhaseStartSetting extends VillagePhaseSetting
{
    function __construct(
        bool $by_manual_flg,
        bool $by_date_flg,
        bool $by_instant_flg,
        ?Carbon $border_date,
    ) {
        parent::__construct(false, $by_manual_flg, false, $by_date_flg, $by_instant_flg, $border_date);
    }

    public function byInstantFlg() : bool{
        return $this->by_instant_flg;
    }

    static public function defaultSetting() : self{
        return new self(true, false, true, null);
    }
}