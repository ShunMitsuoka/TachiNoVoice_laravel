<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Exception;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseSetting;
use Packages\Domain\Models\Village\Topic\Topic;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageMemberRequirement;
use Packages\Domain\Models\Village\VillagePublicInformation;
use Packages\Domain\Models\Village\VillageSetting;
use Packages\Domain\Services\VillageService;

class Member
{
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
        string $email,
        int $gender,
        Carbon $date_of_birth,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
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
        return new Topic($title, $content, $note);
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

    public function makeVillagePhaseStartSetting(
        bool $by_limit_flg,
        bool $by_date_flg,
        bool $by_instant_flg,
        ?Carbon $border_date,
    ){
        return new VillagePhaseSetting(false, true, $by_limit_flg, $by_date_flg, $by_instant_flg, $border_date);
    }

    public function makeVillagePhaseEndSetting(
        bool $by_limit_flg,
        bool $by_date_flg,
        ?Carbon $border_date,
    ){
        return new VillagePhaseSetting(true, true, $by_limit_flg, $by_date_flg, false, $border_date);
    }

    /**
     * ビレッジを登録する
     */
    public function registerVillage(
        VillageService  $village_service,
        Topic $topic,
        VillageSetting $setting,
        VillageMemberRequirement $requirement,
        VillagePublicInformation $public_information,
        VillagePhaseSetting $phase_start_setting,
        VillagePhaseSetting $phase_end_setting
    ) : ?Village{
        $init_phase = VillagePhase::getInitPhase(
            $phase_start_setting,
            $phase_end_setting
        );
        $village = new Village(null, $init_phase, $topic, $setting, $requirement, $public_information);
        return $village_service->registerVillage($this, $village);
    }

    /**
     * ビレッジに参加する
     */
    public function joinVillage(Village $village):bool {
        throw new Exception("Error Processing Request", 1);
    }

}