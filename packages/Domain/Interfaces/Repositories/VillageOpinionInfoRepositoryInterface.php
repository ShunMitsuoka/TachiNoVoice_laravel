<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageOpinionInfo\VillageOpinionInfo;

interface VillageOpinionInfoRepositoryInterface 
{
    public function get(VillageId $village_id) : VillageOpinionInfo;
    public function update(VillageOpinionInfo $village_opinion_info) : bool;
}