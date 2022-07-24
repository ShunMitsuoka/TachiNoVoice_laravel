<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageMemberRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Services\VillageService;

class MyVillageApiController extends BaseApiController
{
    protected VillageService $village_service;

    function __construct(
        VillageService $village_service
    ) {
        $this->village_service = $village_service;
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
        $villages = $this->village_service->villageRepository()->getAllByHost($member->idObj());
        foreach ($villages as $village) {
            $this->village_service->setVillageMember($village);
            $result[] = [
                'id' => $village->id(),
                'phase' => $village->phase()->phase(),
                'phase_status' => $village->phase()->phaseStatus(),
                'title' => $village->topic()->title(),
                'content' => $village->topic()->content(),
                'note' => $village->topic()->note(),
                'core_member_limit' => $village->setting()->coreMemberLimit(),
                'village_member_limit' => $village->setting()->villageMemberLimit(),
            ];
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
