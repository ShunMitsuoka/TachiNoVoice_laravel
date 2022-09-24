<?php

namespace Packages\Domain\Models\Village\VillageDetails\Satisfaction;

use Packages\Domain\Models\Village\VillageDetails\Policy\PolicyId;

class Satisfaction
{
    private PolicyId $policy_id;
    private int $level;

    function __construct(
        PolicyId $policy_id,
        int $level,
    ) {
        $this->policy_id = $policy_id;
        $this->level = $level;
    }

    public function policyId(): PolicyId
    {
        return $this->policy_id;
    }

    public function level(): int
    {
        return $this->level;
    }

}
