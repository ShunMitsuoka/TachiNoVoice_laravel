<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

interface VillageRepositoryInterface
{
    public function get(VillageId $village_id): Village;
    public function save(Village $village): Village;
    public function getAll(array $filter): array;
    // public function getAllJoinedVillage(UserId $userId): array;
}
