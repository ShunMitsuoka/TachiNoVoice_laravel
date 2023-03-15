<?php

namespace Packages\Infrastructure\Repositories;

use App\Models\VillageNotice as ModelsVillageNotice;
use Packages\Domain\Interfaces\Repositories\VillageNoticeRepositoryInterface;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

class VillageNoticeRepository implements VillageNoticeRepositoryInterface
{
    public function get(array $village_id): array
    {
        try {
            $village_notices = ModelsVillageNotice::whereIn('village_id', $village_id)
                                                ->take(5)
                                                ->orderBy('created_at', 'desc')
                                                ->get()
                                                ->toArray();
            return $village_notices;
        } catch (\Exception $e) {
            logs()->error($e->getMessage());
        }
        return [];
    }

    public function save(Village $village, string $content): bool
    {
        try {
            ModelsVillageNotice::create([
                'type' => 1,
                'village_id' => $village->id()->toInt(),
                'content' => $content,
            ]);
            return true;
        } catch (\Exception $e) {
            logs()->error($e->getMessage());
        }
        return [];
    }
}
