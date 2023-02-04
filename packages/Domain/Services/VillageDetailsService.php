<?php
namespace Packages\Domain\Services;

use Packages\Domain\Interfaces\Repositories\VillageDetailsRepositoryInterface;
use Packages\Domain\Models\Village\Village;

class VillageDetailsService{

    protected VillageDetailsRepositoryInterface $village_details_repository;

    function __construct(
        VillageDetailsRepositoryInterface $village_details_repository,
    ) {
        $this->village_details_repository = $village_details_repository;
    }

    public function setDetails(Village $village){
        $this->village_details_repository->get($village);
    } 

    public function updateDetails(Village $village){
        $this->village_details_repository->update($village);
    }
}