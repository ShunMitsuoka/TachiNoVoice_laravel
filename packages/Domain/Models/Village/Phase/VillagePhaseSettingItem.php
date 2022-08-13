<?php
namespace Packages\Domain\Models\Village\Phase;

use Carbon\Carbon;

class VillagePhaseSettingItem
{
    private bool $is_need;
    private string $label;
    private bool $is_selected;
    private ?int $limit;
    private ?Carbon $date;

    function __construct(
        bool $is_need,
        string $label,
        bool $is_selected,
        ?Carbon $date = null,
    ) {
        $this->is_need = $is_need;
        $this->label = $label;
        $this->is_selected = $is_selected;
        $this->date = $date;
    }

    public function isNeed() : bool{
        return $this->is_need;
    }

    public function label() : string{
        return $this->label;
    }

    public function isSelected() : bool{
        return $this->is_selected;
    }

    public function date() : ?Carbon{
        return $this->date;
    }
}