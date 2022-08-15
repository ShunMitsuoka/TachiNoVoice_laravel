<?php
namespace Packages\Domain\Services;

use Packages\Domain\Interfaces\Repositories\VillageOpinionInfoRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Category\CategoryId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\Opinion;

class VillageOpinionInfoService{

    protected VillageOpinionInfoRepositoryInterface $village_opinion_info_repository;

    function __construct(
        VillageOpinionInfoRepositoryInterface $village_opinion_info_repository,
    ) {
        $this->village_opinion_info_repository = $village_opinion_info_repository;
    }

    public function addOpinion(VillageId $village_id, Member $member, string $opinion, ?CategoryId $category_id = null){
        $village_opinion_info = $this->village_opinion_info_repository->get($village_id);
        $village_opinion_info->addOpinion(
            new Opinion(null, $opinion, $member, null, $category_id)
        );
        $this->village_opinion_info_repository->update($village_opinion_info);
    }
}