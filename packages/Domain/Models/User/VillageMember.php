<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;

class VillageMember extends Member
{
    function __construct(
        UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        int $gender,
        Carbon $date_of_birth,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth);
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