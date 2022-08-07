<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Services\VillageService;

class Host extends Member
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
        $this->role_id = self::ROLE_HOST;
    }
}