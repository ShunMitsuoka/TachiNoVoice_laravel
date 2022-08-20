<?php

namespace Packgage\Infrastructure\Repositories;

use App\Models\VillageMember as ModelsVillageMember;
use Packages\Domain\Interfaces\Repositories\VillageDetailsRepositoryInterface;
use Packages\Domain\Models\Village\Village;

class VillageDetailsRepository implements VillageDetailsRepositoryInterface
{
    public function get(Village $village): Village
    {
        $village_id = $village->village_id;
        $village_member_info = $this->village_member_info->get($village_id);
        $core_members = $village_member_info->coreMembers();
        $rise_members = $village_member_info->riseMember();

        foreach ($core_members as $core_member) {
        }
        return $village;
    }

    public function update(Village $village): bool
    {
        return true;
    }
}
