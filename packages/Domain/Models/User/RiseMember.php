<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;

class RiseMember extends VillageMember
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
        $this->role_id = self::ROLE_RISE_MEMBER;
    }
}