<?php
namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Topic\Topic;

class Village
{
    protected ?VillageId $id;
    private VillagePhase $phase;
    private VillageSetting $setting;
    private Topic $topic;
    private VillageMemberRequirement $requirement;
    private VillagePublicInformation $public_information;
    private array $hosts;
    private array $village_members;
    private array $core_members;
    private array $rise_members;

    function __construct(
        ?VillageId $id,
        VillagePhase $phase,
        Topic $topic,
        VillageSetting $setting,
        VillageMemberRequirement $requirement,
        VillagePublicInformation $public_information
    ) {
        $this->id = $id;
        $this->phase = $phase;
        $this->topic = $topic;
        $this->setting = $setting;
        $this->requirement = $requirement;
        $this->public_information = $public_information;
        $this->hosts = [];
        $this->village_members = [];
        $this->core_members = [];
        $this->rise_members = [];
    }

    public function id() : VillageId
    {
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id;
    }

    public function setId(int $id){
        if(!is_null($this->id)){
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new VillageId($id);
    }

    public function phase() : VillagePhase{
        return $this->phase;
    }
    public function topic():Topic{
        return $this->topic;
    }
    public function setting() : VillageSetting{
        return $this->setting;
    }
    public function requirement() : VillageMemberRequirement{
        return $this->requirement;
    }
    public function publicInformation() : VillagePublicInformation{
        return $this->public_information;
    }
    public function hosts(){
        return $this->hosts;
    }
    public function villageMembers(){
        return $this->village_members;
    }
    public function coreMembers(){
        return $this->core_members;
    }
    public function riseMembers(){
        return $this->rise_members;
    }

    public function addHost(Member $host){
        $this->hosts[$host->id()->toInt()] = $host;
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


}