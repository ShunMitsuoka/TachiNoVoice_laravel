<?php
namespace Packages\Domain\Models\Village;

class VillageSetting
{
    private int $village_member_limit;
    private int $core_member_limit;

    function __construct(
        int $village_member_limit,
        int $core_member_limit,
    ) {
        $this->village_member_limit = $village_member_limit;
        $this->core_member_limit = $core_member_limit;
    }

    public function coreMemberLimit() : int{
        return $this->core_member_limit;
    }

    public function villageMemberLimit() : int{
        return $this->village_member_limit;
    }

}