<?php

namespace Packages\Domain\Interfaces\Repositories;

use Dotenv\Util\Str;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageNotice\VillageNotice;
use Packages\Domain\Models\Village\VillageId;

interface VillageNoticeRepositoryInterface
{
    public function get(array $village_id): array;
    public function save(Village $village, string $content): bool;
}
