<?php

namespace Packages\Infrastructure\Repositories;

use Exception;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\Village;

class VillageRepository implements VillageRepositoryInterface
{
    public function save(Village $village) : Village{
        throw new Exception("Error Processing Request", 1);
    }
}