<?php
namespace Packages\Domain\Services;

use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

class VillagePermissionService{

    protected VillageRepositoryInterface $village_repository;

    function __construct(
        VillageRepositoryInterface $village_repository,
    ) {
        $this->village_repository = $village_repository;
    }

    public function checkPermission(Village $village, Member $member) : bool{
        return $this->village_repository->checkPermission($village, $member);
    }

}