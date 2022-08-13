<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Models\User\CoreMember;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\RiseMember;
use Packages\Domain\Models\User\VillageMember;

class MemberCast{

    static public function castMember($member) : Member{
        return $member;
    }

    static public function castHost($member) : Host{
        return $member;
    }

    static public function castVillageMember($member) : VillageMember{
        return $member;
    }

    static public function castCoreMember($member) : CoreMember{
        return $member;
    }

    static public function castRiseMember($member) : RiseMember{
        return $member;
    }

}