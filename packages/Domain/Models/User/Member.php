<?php

namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Exception;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseEndSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseStartSetting;
use Packages\Domain\Models\Village\Topic\Topic;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberRequirement;
use Packages\Domain\Models\Village\VillagePublicInformation;
use Packages\Domain\Models\Village\VillageSetting;
use Packages\Domain\Services\VillagePhaseService;
use Packages\Domain\Services\VillageService;

class Member extends User
{

    protected int $role_id;
    /**
     * 役割:ホスト
     */
    public const ROLE_HOST  = 1;

    /**
     * 役割:ビレッジメンバー
     */
    public const ROLE_VILLAGE_MEMBER  = 10;
    /**
     * 役割:コアメンバー
     */
    public const ROLE_CORE_MEMBER  = 20;
    /**
     * 役割:ライズメンバー
     */
    public const ROLE_RISE_MEMBER  = 30;

    function __construct(
        ?UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        int $gender,
        Carbon $date_of_birth,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth);
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
        VillagePhaseStartSetting $phase_start_setting,
        VillagePhaseEndSetting $phase_end_setting
    ): ?Village {
        $init_phase = VillagePhaseService::getInitPhase(
            $phase_start_setting,
            $phase_end_setting
        );
        $village = new Village(null, $init_phase, $topic, $setting, $requirement, $public_information);
        return $village_service->registerVillage($this, $village);
    }

    /**
     * ビレッジに参加する
     */
    public function joinVillage(VillageId $village_id, Village $village): bool
    {
        // return $village->registerVillage($this, $village);
        return false;
        // throw new Exception("Error Processing Request", 1);
    }


    // public function becomeVillageMember() : VillageMember{
    //     return new VillageMember(
    //         $this->id(),
    //         $this->name(),
    //         $this->nickname(),
    //         $this->email(),
    //         $this->gender(),
    //         $this->dateOfBirth()
    //     );
    // }

    // public function becomeCoreMember() : CoreMember{
    //     return new CoreMember(
    //         $this->id(),
    //         $this->name(),
    //         $this->nickname(),
    //         $this->email(),
    //         $this->gender(),
    //         $this->dateOfBirth()
    //     );
    // }

    // public function becomeRiseMember() : RiseMember{
    //     return new RiseMember(
    //         $this->id(),
    //         $this->name(),
    //         $this->nickname(),
    //         $this->email(),
    //         $this->gender(),
    //         $this->dateOfBirth()
    //     );
    // }
}
