<?php
namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\User\VillageMember;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

interface VillageMemberRepositoryInterface 
{
    public function save(VillageId $village_id, VillageMember $member) : bool;
    public function getAllByVillageId(int $village_id) : array;
}