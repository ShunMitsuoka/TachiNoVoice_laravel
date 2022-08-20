<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\Village\Village;

interface VillageDetailsRepositoryInterface
{
    public function get(Village $village): Village;
    public function update(Village $village): bool;
}
