<?php
namespace Packages\Domain\Models\Village\Phase;

use Carbon\Carbon;

class VillagePhaseEndSetting extends VillagePhaseSetting
{

    function __construct(
        bool $by_manual_flg,
        bool $by_limit_flg,
        bool $by_date_flg,
        ?Carbon $border_date,
    ) {
        parent::__construct(true, $by_manual_flg, $by_limit_flg, $by_date_flg, false, $border_date);

    }

    public function byLimitFlg() : bool{
        return $this->by_limit_flg;
    }

    static public function defaultSetting() : self{
        return new self(true, true, false, null);
    }

}