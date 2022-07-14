<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Services\VillageService;

class Host extends Member
{
    protected Village $village;
    function __construct(
        MemberId $id,
        string $name,
        string $nickname,
        ?string $email,
        int $gender,
        Carbon $date_of_birth,
        Village $village,
        VillageService  $village_service
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth, $village_service);
        $this->village = $village;
    }
}