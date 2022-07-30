<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;

class VillageMember extends Member
{
    private int $role_id;

    /**
     * 役割:ビレッジメンバー
     */
    public const ROLE_VILLAGE_MEMBER  = 1;

    /**
     * 役割:コアメンバー
     */
    public const ROLE_CORE_MEMBER  = 2;

    /**
     * 役割:ライズメンバー
     */
    public const ROLE_RISE_MEMBER  = 3;

    function __construct(
        MemberId $id,
        string $name,
        ?string $nickname,
        string $email,
        int $gender,
        Carbon $date_of_birth,
        int $role_id,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth);
        $this->role_id = $role_id;
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
}