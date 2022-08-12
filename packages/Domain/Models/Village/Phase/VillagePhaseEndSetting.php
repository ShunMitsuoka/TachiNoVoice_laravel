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
        $this->end_flg = true;
        $this->by_manual_flg = $by_manual_flg;
        $this->by_limit_flg = $by_limit_flg;
        $this->by_date_flg = $by_date_flg;
        $this->by_instant_flg = false;
        $this->border_date = $border_date;
    }

    public function isEndPhase() : bool{
        return $this->end_flg;
    }

    public function byManual() : bool{
        return $this->by_manual_flg;
    }

    public function byLimit() : bool{
        return $this->by_limit_flg;
    }

    public function byDate() : bool{
        return $this->by_date_flg;
    }

    public function byInstant() : bool{
        return $this->by_instant_flg;
    }

    public function borderDate() : ?Carbon{
        return $this->border_date;
    }
}