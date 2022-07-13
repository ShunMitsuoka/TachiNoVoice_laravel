<?php
namespace Packages\Domain\Models\Village;

class VillageSetting
{
    private int $core_member_limit;

    function __construct(
        int $core_member_limit,
    ) {
        $this->core_member_limit = $core_member_limit;
    }

    public function getCoreMemberLimit() : int{
        return $this->core_member_limit;
    }

}