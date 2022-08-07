<?php
namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\User\Member;

class VillageMemberInfo
{
    private array $hosts;
    private array $village_members;
    private array $core_members;
    private array $rise_members;

    function __construct(
        array $hosts,
        array $village_members,
        array $core_members,
        array $rise_members,
    ){
        $this->hosts = $hosts;
        $this->village_members = $village_members;
        $this->core_members = $core_members;
        $this->rise_members = $rise_members;
    }

    public function hosts() : array{
        return $this->hosts;
    }

    public function villageMembers() : array{
        return $this->village_members;
    }

    public function coreMembers() : array{
        return $this->core_members;
    }

        public function riseMembers() : array{
        return $this->rise_members;
    }

    public function addHost(Member $member){
        $this->hosts[$member->id()->toInt()] = $member;
    }

    public function addVillageMember(Member $member){
        $this->village_members[$member->id()->toInt()] = $member;
    }

    public function addCoreMember(Member $member){
        $this->core_members[$member->id()->toInt()] = $member;
    }

    public function addRiseMember(Member $member){
        $this->rise_members[$member->id()->toInt()] = $member;
    }

    public function isHost(Member $member) : bool{
        return array_key_exists($member->id()->toInt(), $this->hosts);
    }

    public function isVillageMember(Member $member) : bool{
        return array_key_exists($member->id()->toInt(), $this->village_members);
    }

    public function isCoreMember(Member $member) : bool{
        return array_key_exists($member->id()->toInt(), $this->core_members);
    }

    public function isRiseMember(Member $member) : bool{
        return array_key_exists($member->id()->toInt(), $this->rise_members);
    }

}