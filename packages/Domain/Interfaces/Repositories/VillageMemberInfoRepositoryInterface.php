<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberInfo;

interface VillageMemberInfoRepositoryInterface 
{
    public function get(VillageId $village_id) : VillageMemberInfo;
    public function update(VillageId $village_id, VillageMemberInfo $village_member_info) : bool;
}