<?php
namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\User\CoreMember;
use Packages\Domain\Models\User\Host;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\RiseMember;
use Packages\Domain\Models\User\VillageMember;

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
        $this->hosts[$member->id()->toInt()] = new Host(
            $member->id(),
            $member->name(),
            $member->nickname(),
            $member->email(),
            $member->gender(),
            $member->dateOfBirth()
        );;
    }

    public function addVillageMember(Member $member){
        $this->village_members[$member->id()->toInt()] = new VillageMember(
            $member->id(),
            $member->name(),
            $member->nickname(),
            $member->email(),
            $member->gender(),
            $member->dateOfBirth()
        );;
    }

    public function addCoreMember(Member $member){
        $this->core_members[$member->id()->toInt()] = new CoreMember(
            $member->id(),
            $member->name(),
            $member->nickname(),
            $member->email(),
            $member->gender(),
            $member->dateOfBirth()
        );
    }

    public function addRiseMember(Member $member){
        $this->rise_members[$member->id()->toInt()] = new RiseMember(
            $member->id(),
            $member->name(),
            $member->nickname(),
            $member->email(),
            $member->gender(),
            $member->dateOfBirth()
        );
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

    public function getHostCount() : int{
        return count($this->hosts);
    }

    public function getVillageMemberCount() : int{
        return count($this->village_members);
    }

    public function getCoreMemberCount() : int{
        return count($this->core_members);
    }

    public function getRiseMemberCount() : int{
        return count($this->rise_members);
    }
}