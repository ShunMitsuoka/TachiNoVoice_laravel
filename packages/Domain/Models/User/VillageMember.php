<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\VillageId;

class VillageMember extends Member
{
    protected VillageId $village_id;

    function __construct(
        VillageId $village_id,
        UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        Gender $gender,
        Carbon $date_of_birth,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth);
        $this->$village_id = $village_id;
        $this->role_id = self::ROLE_VILLAGE_MEMBER;
    }

    public function giveAnOpinion()
    {
        # code...
    }

    public function isVillageMember(){
        return $this->role_id === self::ROLE_VILLAGE_MEMBER;
    }

    public function isCoreMember(){
        return $this->role_id === self::ROLE_CORE_MEMBER;
    }

    public function isRiseMember(){
        return $this->role_id === self::ROLE_RISE_MEMBER;
    }

    public function role() : int{
        return $this->role_id;
    }
}