<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\Api\BaseApiController;
use App\Mail\TestMail;
use App\Services\VillageApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\Casts\VillageCast;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillageService;

class MyVillageApiController extends BaseApiController
{
    protected VillageService $village_service;
    protected VillageDetailsService $village_details_service;
    protected VillageRepositoryInterface $village_repository;

    function __construct(
        VillageService $village_service,
        VillageDetailsService $village_details_service,
        VillageRepositoryInterface $village_repository,
    ) {
        $this->village_service = $village_service;
        $this->village_details_service = $village_details_service;
        $this->village_repository = $village_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $member = $this->getLoginMember();
        $joining_villages = $this->village_repository->getAllJoiningVillage($member->id());
        foreach ($joining_villages as $village) {
            $village = VillageCast::castVillage($village);
            $village->setMemberInfo($this->village_service);
            $result[] = VillageApiResponseService::villageResponse($village, $member);
        }
        return $this->makeSuccessResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = [];
        $member = $this->getLoginMember();
        $village = $this->village_repository->get(new VillageId($id));
        $village->setMemberInfo($this->village_service);
        $this->village_details_service->setDetails($village);
        $result = VillageApiResponseService::villageResponse($village, $member);
        return $this->makeSuccessResponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
