<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\API\BaseApiController;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\Casts\MemberCast;
use Packages\Domain\Services\VillageService;

class MyVillageMemberApiController extends BaseApiController
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = [];
        $village = $this->village_repository->get(new VillageId($id));
        $village->setMemberInfo($this->village_service);
        $member_info = $village->memberInfo();
        $public_info = $village->publicInformation();
        $village_members = [];
        $core_members = [];
        $rise_members = [];
        foreach ($member_info->villageMembers() as $village_member) {
            $village_member = MemberCast::castMember($village_member);
            $village_members[] = [
                'nickname' => $public_info->isNicknamePublic() ? $village_member->nickname() : null,
                'age' => $public_info->isAgePublic() ? $village_member->age() : null,
                'gender' => $public_info->isGenderPublic() ? $village_member->gender() : null,
            ];
        }

        foreach ($member_info->coreMembers() as $core_member) {
            $core_member = MemberCast::castMember($core_member);
            $core_members[] = [
                'nickname' => $public_info->isNicknamePublic() ? $core_member->nickname() : null,
                'age' => $public_info->isAgePublic() ? $core_member->age() : null,
                'gender' => $public_info->isGenderPublic() ? $core_member->gender() : null,
            ];
        }

        foreach ($member_info->riseMembers() as $rise_member) {
            $rise_member = MemberCast::castMember($rise_member);
            $rise_members[] = [
                'nickname' => $public_info->isNicknamePublic() ? $rise_member->nickname() : null,
                'age' => $public_info->isAgePublic() ? $rise_member->age() : null,
                'gender' => $public_info->isGenderPublic() ? $rise_member->gender() : null,
            ];
        }

        $result = [
            'village_id' => $village->id()->toInt(),
            'phase_no' => $village->phase()->phaseNo(),
            'phase_name' => $village->phase()->phaseName(),
            'phase_status' => $village->phase()->phaseStatus(),
            'title' => $village->topic()->title(),
            'core_member_limit' => $village->setting()->coreMemberLimit(),
            'village_member_limit' => $village->setting()->villageMemberLimit(),
            'village_member_count' => $village->memberInfo()->getVillageMemberCount(),
            'core_member_count' => $village->memberInfo()->getCoreMemberCount(),
            'rise_member_count' => $village->memberInfo()->getRiseMemberCount(),
            'members' => [
                'village_members' => $village_members,
                'core_members' => $core_members,
                'rise_members' => $rise_members,
            ]
        ];

        return $this->makeSuccessResponse($result);
    }
}
