<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\Phase\VillagePhaseEndSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseStartSetting;
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

    public function setting($id, Request $request)
    {
        //
        $village = $this->village_repository->get(new VillageId($id));
        if($village->phase()->isNecessaryToSetPhaseStartSetting()){
            $phase_start_setting = new VillagePhaseStartSetting(
                $request->start_by_manual_flg,
                $request->start_by_date_flg,
                $request->start_by_instant_flg,
                $request->start_by_date_flg ? new Carbon($request->start_date) : null,
            );
            $village->phase()->updatePhaseStartSetting($phase_start_setting);
        }
        if($village->phase()->isNecessaryToSetPhaseEndSetting()){
            $phase_end_setting = new VillagePhaseEndSetting(
                $request->end_by_manual_flg,
                $request->end_by_limit_flg,
                $request->end_by_date_flg,
                $request->end_by_date_flg ? new Carbon($request->end_date) : null,
            );
            $village->phase()->updatePhaseEndSetting($phase_end_setting);
        }
        $this->village_repository->update($village);
        return $this->makeSuccessResponse([]);
    }
}
