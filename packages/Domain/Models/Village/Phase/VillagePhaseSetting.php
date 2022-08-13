<?php
namespace Packages\Domain\Models\Village\Phase;

use Carbon\Carbon;

class VillagePhaseSetting
{
    private bool $end_flg;
    protected bool $by_manual_flg;
    protected bool $by_limit_flg;
    protected bool $by_date_flg;
    protected bool $by_instant_flg;
    protected ?Carbon $border_date;

    function __construct(
        bool $end_flg,
        bool $by_manual_flg,
        bool $by_limit_flg,
        bool $by_date_flg,
        bool $by_instant_flg,
        ?Carbon $border_date,
    ) {
        $this->end_flg = $end_flg;
        $this->by_manual_flg = $by_manual_flg;
        $this->by_limit_flg = $by_limit_flg;
        $this->by_date_flg = $by_date_flg;
        $this->by_instant_flg = $by_instant_flg;
        $this->border_date = $border_date;
    }

    public function isEndPhase() : bool{
        return $this->end_flg;
    }

    public function byManualFlg() : bool{
        return $this->by_manual_flg;
    }

    public function byDateFlg() : bool{
        return $this->by_date_flg;
    }

    public function borderDate() : ?Carbon{
        return $this->border_date;
    }
}