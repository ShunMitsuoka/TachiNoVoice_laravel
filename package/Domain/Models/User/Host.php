<?php
namespace Packages\Domain\Models\User;

use Packages\Domain\Models\Topic\Topic;
use Packages\Domain\Models\Topic\TopicId;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageSetting;

class Host extends Member
{

    /**
     * ビレッジを作成する
     */
    public function makeVillage():Village
    {
        return new Village(null);
    }
    /**
     * ビレッジに問いを設定する。
     */
    public function setVillageTopic(
        Village $village,
        string $title,
        ?string $content,
        ?string $note,
    ){
        $village->setTopic(
            new Topic(null, $title, $content, $note)
        );
    }

    /**
     * ビレッジの設定を行う。
     */
    public function setVillageSetting(
        Village $village,
        int $core_member_limit,
    ){
        $village->setSetting(new VillageSetting($core_member_limit));
    }
}