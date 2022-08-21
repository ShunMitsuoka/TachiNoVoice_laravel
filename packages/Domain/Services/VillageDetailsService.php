<?php
namespace Packages\Domain\Services;

use Packages\Domain\Interfaces\Repositories\VillageDetailsRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;
use Packages\Domain\Models\Village\VillageDetails\Opinion\Opinion;
use Packages\Domain\Models\Village\VillageId;

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

    public function addOpinion(VillageId $village_id, Member $member, string $opinion, ?CategoryId $category_id = null){
        $village_opinion_info = $this->village_opinion_info_repository->get($village_id);
        $village_opinion_info->addOpinion(
            new Opinion(null, $opinion, null, $category_id)
        );
        $this->village_opinion_info_repository->update($village_opinion_info);
    }
}