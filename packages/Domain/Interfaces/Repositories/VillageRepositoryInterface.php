<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\Collections\BaseCollection;
use Packages\Domain\Models\Filter\JoinningVillageFilter;
use Packages\Domain\Models\Filter\SearchVillageFilter;
use Packages\Domain\Models\User\Member;
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
     * ビレッジを更新する
     */
    public function update(Village $village): Village;
    /**
     * 検索条件に一致するビレッジを全件取得する。
     */
    public function getAll(SearchVillageFilter $filter): array;
    /*
     * ユーザーが参加しているビレッジを全件取得する。
     */
    public function getAllJoiningVillage(UserId $userId, JoinningVillageFilter $filter): BaseCollection;
    /**
     * ユーザーが参加可能かどうか確認する。
     */
    public function checkPermission(Village $village, Member $member): bool;

}
