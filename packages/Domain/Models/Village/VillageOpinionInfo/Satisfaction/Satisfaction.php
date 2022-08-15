<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo\Satisfaction;

use Packages\Domain\Models\User\Member;

class Satisfaction
{
    private Member $member;
    private int $level;
    private ?string $comment;

    function __construct(
        Member $member,
        int $level,
        ?string $comment,
    ) {
        $this->member = $member;
        $this->level = $level;
        $this->comment = $comment;
    }

    public function member() : Member{
        return $this->member;
    }

    public function level() : int{
        return $this->level;
    }

    public function comment() : string{
        return $this->comment;
    }

}