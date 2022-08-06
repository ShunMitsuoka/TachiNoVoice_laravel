<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

interface VillageRepositoryInterface
{
    public function get(VillageId $village_id) : Village;
    public function save(Village $village) : Village;
    public function getAll(array $filter): array;
    public function getAllAsHost(UserId $member_id) : array;
    public function getAllAsVillageMember(UserId $member_id) : array;
    public function getAllAsCoreMember(UserId $member_id) : array;
    public function getAllAsRiseMember(UserId $member_id) : array;
}
