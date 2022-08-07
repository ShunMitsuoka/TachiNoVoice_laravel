<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Services\Casts\VillageCast;
use Packages\Domain\Services\VillageService;

class MyVillageApiController extends BaseApiController
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
            $result[] = $this->makeResultFromRecord($village, $village->getMemberRole($member));
        }
        return $this->makeSuccessResponse($result);
    }

    private function makeResultFromRecord(Village $village, int $role_id){
        return [
            'village_id' => $village->id()->toInt(),
            'phase' => $village->phase()->phase(),
            'phase_name' => $village->phase()->getPhaseName(),
            'phase_status' => $village->phase()->phaseStatus(),
            'title' => $village->topic()->title(),
            'content' => $village->topic()->content(),
            'note' => $village->topic()->note(),
            'core_member_limit' => $village->setting()->coreMemberLimit(),
            'village_member_limit' => $village->setting()->villageMemberLimit(),
            'role_id' => $role_id,
            'village_member_count' => $village->memberInfo()->getVillageMemberCount(),
            'core_member_count' => $village->memberInfo()->getCoreMemberCount(),
            'rise_member_count' => $village->memberInfo()->getRiseMemberCount(),
        ];
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
