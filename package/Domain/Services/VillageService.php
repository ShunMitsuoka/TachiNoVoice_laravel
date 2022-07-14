<?php
namespace Packages\Domain\Services;

use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

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
     * ビレッジを登録する
     */
    public function registerVillage(Member $register_member, Village $village) : bool{
        try {
            $registered_village = $this->village_repository->save($village);
            $this->host_repository->save($register_member, $registered_village);
            return true;
        } catch (\Throwable $th) {
            logs()->error($th->getMessage());
        }
        return false;
    }
}