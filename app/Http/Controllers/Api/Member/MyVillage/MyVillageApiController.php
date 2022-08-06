<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;
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
        $host_villages = $this->village_repository->getAllAsHost($member->id());
        $village_member_villages = $this->village_repository->getAllAsVillageMember($member->id());
        $core_member_villages = $this->village_repository->getAllAsCoreMember($member->id());
        $rise_member_villages = $this->village_repository->getAllAsRiseMember($member->id());
        foreach ($host_villages as $village) {
            $village->setMemberInfo($this->village_service);
            $result[] = $this->makeResultFromRecord($village, Member::ROLE_HOST);
        }
        foreach ($village_member_villages as $village) {
            $village->setMemberInfo($this->village_service);
            $result[] = $this->makeResultFromRecord($village, Member::ROLE_VILLAGE_MEMBER);
        }
        foreach ($core_member_villages as $village) {
            $village->setMemberInfo($this->village_service);
            $result[] = $this->makeResultFromRecord($village, Member::ROLE_CORE_MEMBER);
        }
        foreach ($rise_member_villages as $village) {
            $village->setMemberInfo($this->village_service);
            $result[] = $this->makeResultFromRecord($village, Member::ROLE_RISE_MEMBER);
        }
        return $this->makeSuccessResponse($result);
    }

    private function makeResultFromRecord(Village $village, int $role_id){
        return [
            'id' => $village->id()->toInt(),
            'phase' => $village->phase()->phase(),
            'phase_name' => $village->phase()->getPhaseName(),
            'phase_status' => $village->phase()->phaseStatus(),
            'title' => $village->topic()->title(),
            'content' => $village->topic()->content(),
            'note' => $village->topic()->note(),
            'core_member_limit' => $village->setting()->coreMemberLimit(),
            'village_member_limit' => $village->setting()->villageMemberLimit(),
            'role_id' => $role_id,
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
