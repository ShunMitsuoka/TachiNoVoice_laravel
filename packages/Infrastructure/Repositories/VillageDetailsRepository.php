<?php

namespace Packgage\Infrastructure\Repositories;


use Packages\Domain\Interfaces\Repositories\VillageDetailsRepositoryInterface;
use Packages\Domain\Models\Village\Village;

class VillageDetailsRepository implements VillageDetailsRepositoryInterface
{
    public function get(Village $village): Village
    {

        return $village;
    }

    public function update(Village $village): bool
    {
        return true;
    }
}
