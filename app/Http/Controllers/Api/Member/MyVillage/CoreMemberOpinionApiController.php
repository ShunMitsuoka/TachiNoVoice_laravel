<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageOpinionInfoService;
use Packages\Domain\Services\VillageService;

class CoreMemberOpinionApiController extends BaseApiController
{
    protected VillageService $village_service;
    protected VillageOpinionInfoService $village_opinion_info_service;
    protected VillageRepositoryInterface $village_repository;

    function __construct(
        VillageService $village_service,
        VillageOpinionInfoService $village_opinion_info_service,
        VillageRepositoryInterface $village_repository,
    ) {
        $this->village_service = $village_service;
        $this->village_opinion_info_service = $village_opinion_info_service;
        $this->village_repository = $village_repository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($village_id, Request $request)
    {
        try {
            DB::transaction();
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            $village->setMemberInfo($this->village_service);
            $core_member = $member->becomeCoreMember($village);
            $core_member->giveAnOpinion($request->opinion, $this->village_opinion_info_service);
            DB::commit();
            return $this->makeSuccessResponse([]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
