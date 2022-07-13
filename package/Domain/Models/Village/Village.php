<?php
namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\Topic\Topic;
use Packages\Domain\Models\Topic\TopicId;

class Village
{
    protected ?VillageId $id;
    private VillageSetting $setting;
    private Topic $topic;

    function __construct(
        ?VillageId $id,
    ) {
        $this->id = $id;
    }

    public function setTopic(Topic $topic){
        $this->topic = $topic;
    }

    public function setSetting(VillageSetting $setting){
        $this->setting = $setting;
    }

}