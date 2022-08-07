<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

interface VillageRepositoryInterface
{
    /**
     * ビレッジIDからビレッジを1件取得する
     */
    public function get(VillageId $village_id): Village;
    /**
     * ビレッジを保存する
     */
    public function save(Village $village): Village;
    /**
     * 検索条件に一致するビレッジを全件取得する。
     */
    public function getAll(array $filter): array;
    public function getAllJoinedVillage(UserId $userId): array;
}
