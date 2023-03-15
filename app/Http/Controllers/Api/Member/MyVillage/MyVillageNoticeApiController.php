<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\VillageNoticeRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Filter\JoinningVillageFilter;
use Packages\Domain\Services\Casts\VillageCast;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillageService;

class MyVillageNoticeApiController extends BaseApiController
{
    protected VillageService $village_service;
    protected VillageDetailsService $village_details_service;
    protected VillageRepositoryInterface $village_repository;
    protected VillageNoticeRepositoryInterface $village_notice_repository;

    function __construct(
        VillageService $village_service,
        VillageDetailsService $village_details_service,
        VillageRepositoryInterface $village_repository,
        VillageNoticeRepositoryInterface $village_notice_repository,
    ) {
        $this->village_service = $village_service;
        $this->village_details_service = $village_details_service;
        $this->village_repository = $village_repository;
        $this->village_notice_repository = $village_notice_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = [];
        $member = $this->getLoginMember();
        $filter = new JoinningVillageFilter($request->recordNum, $request->finishedFlg == 'true');
        $joining_villages = $this->village_repository->getAllJoiningVillage($member->id(),  $filter);
        foreach ($joining_villages->items() as $village) {
            $village = VillageCast::castVillage($village);
            $village->setMemberInfo($this->village_service);
            array_push($id,$village->id()->toInt());
        }
        $result = $this->village_notice_repository->get($id);
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
