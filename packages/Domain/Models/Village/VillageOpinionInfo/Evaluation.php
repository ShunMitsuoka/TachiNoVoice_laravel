<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo;

use Packages\Domain\Models\User\Member;

class Evaluation
{
    private Member $member;
    private int $value;

    function __construct(
        Member $member,
        int $value,
    ) {
        $this->member = $member;
        $this->value = $value;
    }

    public function member() : Member{
        return $this->member;
    }

    public function value() : int{
        return $this->value;
    }

}