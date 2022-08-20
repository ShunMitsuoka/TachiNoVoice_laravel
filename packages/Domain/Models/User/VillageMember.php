<?php

namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Package\Domain\Models\Village\VillageDetails\Review\Review;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\VillageId;

class VillageMember extends Member
{
    protected VillageId $village_id;
    private array $opinion;
    private array $evaluations;
    private ?Review $review;

    function __construct(
        VillageId $village_id,
        UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        Gender $gender,
        Carbon $date_of_birth,
        array $opinions = [],
        array $evaluations = [],
        ?Review $review = null,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth, $opinions, $evaluations, $review);
        $this->village_id = $village_id;
        $this->role_id = self::ROLE_VILLAGE_MEMBER;
        $this->opinion = $opinions;
        $this->evaluations = $evaluations;
        $this->review = $review;
    }

    public function isVillageMember()
    {
        return $this->role_id === self::ROLE_VILLAGE_MEMBER;
    }

    public function isCoreMember()
    {
        return $this->role_id === self::ROLE_CORE_MEMBER;
    }

    public function isRiseMember()
    {
        return $this->role_id === self::ROLE_RISE_MEMBER;
    }

    public function role(): int
    {
        return $this->role_id;
    }

    public function opinions(): array
    {
        return $this->opinions;
    }

    public function evaluations(): array
    {
        return $this->evaluations;
    }

    public function review(): Review
    {
        return $this->review;
    }
}
