<?php
namespace Packages\Domain\Services;

use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;

class VillageService{

    protected VillageRepositoryInterface $village_repository;
    protected HostRepositoryInterface $host_repository;

    function __construct(
        VillageRepositoryInterface $village_repository,
        HostRepositoryInterface $host_repository,
    ) {
        $this->village_repository = $village_repository;
        $this->host_repository = $host_repository;
    }
    /**
     * idからビレッジを取得する
     */
    public function getVillage(VillageId $village_id) : ?Village{
        try {
            $village_details = $this->village_repository->get($village_id);
            return $village_details;
        } catch (\Throwable $th) {
            logs()->error($th->getMessage());
        }
        return null;
    }

    /**
     * ビレッジを登録する
     */
    public function registerVillage(Member $register_member, Village $village) : ?Village{
        DB::beginTransaction();
        try {
            $registered_village = $this->village_repository->save($village);
            $this->host_repository->save($register_member, $registered_village);
            DB::commit();
            return $registered_village;
        } catch (\Throwable $th) {
            DB::rollback();
            logs()->error($th->getMessage());
        }
        return null;
    }
}