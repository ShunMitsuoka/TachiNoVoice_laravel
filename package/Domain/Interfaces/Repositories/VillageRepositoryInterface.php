<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\Village\Village;

interface VillageRepositoryInterface 
{
    public function save(Village $village) : Village;
}