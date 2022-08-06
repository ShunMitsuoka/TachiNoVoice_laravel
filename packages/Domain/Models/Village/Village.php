<?php
namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Topic\Topic;
use Packages\Domain\Services\VillageService;

class Village extends _Entity
{
    protected ?VillageId $id;
    public readonly VillagePhase $phase;
    public readonly VillageSetting $setting;
    public readonly Topic $topic;
    public readonly VillageMemberRequirement $requirement;
    public readonly VillagePublicInformation $public_information;
    protected ?VillageMemberInfo $member_info;

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
    public function memberInfo(){
        if(is_null($this->member_info)){
            throw new \Exception('メンバー情報が存在しません。');
        }
        return $this->member_info;
    }

    public function setMemberInfo(VillageService $service){
        $this->member_info = $service->getVillageMemberInfo($this);
    }

}