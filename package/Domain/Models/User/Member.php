<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\Topic\Topic;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageMemberRequirement;
use Packages\Domain\Models\Village\VillagePhase;
use Packages\Domain\Models\Village\VillagePublicInformation;
use Packages\Domain\Models\Village\VillageSetting;
use Packages\Domain\Services\VillageService;

class Member
{
    protected VillageService $village_service;

    protected ?MemberId $id;
    private string $name;
    private string $nickname;
    private string $email;
    private int $gender;
    private Carbon $date_of_birth;

    function __construct(
        ?MemberId $id,
        string $name,
        string $nickname,
        ?string $email,
        int $gender,
        Carbon $date_of_birth,
        VillageService  $village_service,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->village_service = $village_service;
    }

    public function id():int{
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id->id();
    }

    public function name():string{
        return $this->name;
    }

    public function nickname():string{
        return $this->nickname;
    }

    public function email():string {
        return $this->email;
    }

    public function gender():int{
        return $this->gender;
    }

    public function dateOfBirth():Carbon{
        return $this->date_of_birth;
    }

    /**
     * ビレッジに問いを作成する。
     */
    public function makeVillageTopic(
        string $title,
        ?string $content,
        ?string $note,
    ) : Topic{
        return new Topic(null, $title, $content, $note);
    }

    /**
     * ビレッジの設定を作成する。
     */
    public function makeVillageSetting(int $core_member_limit) : VillageSetting{
        return new VillageSetting($core_member_limit);
    }

    /**
     * ビレッジメンバー参加条件を作成する。
     */
    public function makeVillageMemberRequirement(string $requirement) : VillageMemberRequirement{
        return new VillageMemberRequirement($requirement);
    }

    /**
     * ビレッジ公開情報を作成する。
     */
    public function makeVillagePublicInformation(
        bool $nickname_flg,
        bool $gender_flg,
        bool $age_flg
    ) : VillagePublicInformation{
        return new VillagePublicInformation($nickname_flg, $gender_flg, $age_flg);
    }

    /**
     * ビレッジを登録する
     */
    public function registerVillage(
        Topic $topic,
        VillageSetting $setting,
        VillageMemberRequirement $requirement,
        VillagePublicInformation $public_information
    ) : ?Village{
        $init_phase = new VillagePhase(0);
        $village = new Village(null, $init_phase, $topic, $setting, $requirement, $public_information);
        return $this->village_service->registerVillage($this, $village);
    }

}