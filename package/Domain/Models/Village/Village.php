<?php
namespace Packages\Domain\Models\Village;


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

    public function id() : int
    {
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id->id();
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



}