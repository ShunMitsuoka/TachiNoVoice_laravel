<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\VillageDetails\Opinion\Opinion;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageDetailsService;

class CoreMember extends VillageMember
{
    function __construct(
        VillageId $village_id,
        UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        Gender $gender,
        Carbon $date_of_birth,
    ) {
        parent::__construct($village_id, $id, $name, $nickname, $email, $gender, $date_of_birth);
        $this->role_id = self::ROLE_CORE_MEMBER;
    }

    public function giveAnOpinion(string $opinion){
        $this->opinions[] = new Opinion(null, $opinion, null);
    }
}