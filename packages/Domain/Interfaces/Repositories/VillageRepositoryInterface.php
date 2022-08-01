<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

interface VillageRepositoryInterface 
{
    public function get(VillageId $village_id) : Village;
    public function save(Village $village) : Village;
    public function getAllAsHost(MemberId $member_id) : array;
    public function getAllAsVillageMember(MemberId $member_id) : array;
    public function getAllAsCoreMember(MemberId $member_id) : array;
    public function getAllAsRiseMember(MemberId $member_id) : array;

}