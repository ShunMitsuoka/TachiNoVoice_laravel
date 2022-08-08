<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageId;

class MyVillagePhaseApiController extends BaseApiController
{
    protected VillageRepositoryInterface $village_repository;

    function __construct(
        VillageRepositoryInterface $village_repository,
    ) {
        $this->village_repository = $village_repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function start($id)
    {
        //
        $result = [];
        $member = $this->getLoginMember();
        $village = $this->village_repository->get(new VillageId($id));
        $village->phase()->startPhase();
        $this->village_repository->update($village);
        return $this->makeSuccessResponse([]);
    }
}
