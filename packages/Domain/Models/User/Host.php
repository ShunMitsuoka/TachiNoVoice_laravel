<?php

namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\VillageId;

class Host extends Member
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
        $this->village_id = $village_id;
        $this->role_id = self::ROLE_HOST;
    }
}
