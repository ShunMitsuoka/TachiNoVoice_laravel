<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageService;

class MyVillagePhaseApiController extends BaseApiController
{
    protected VillageService $village_service;
    protected VillageRepositoryInterface $village_repository;

    function __construct(
        VillageService $village_service,
        VillageRepositoryInterface $village_repository,
    ) {
        $this->village_service = $village_service;
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
        $village->setMemberInfo($this->village_service);
        if(!$village->memberInfo()->isHost($member)){
            return $this->makeErrorResponse([]);
        }
        $this->village_service->startPhase($village);
        return $this->makeSuccessResponse([]);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function next($id)
    {
        //
        $result = [];
        $member = $this->getLoginMember();
        $village = $this->village_repository->get(new VillageId($id));
        $village->setMemberInfo($this->village_service);
        if(!$village->memberInfo()->isHost($member)){
            return $this->makeErrorResponse([]);
        }
        $this->village_service->nextPhase($village);
        return $this->makeSuccessResponse([]);
    }
}
