<?php

namespace App\Http\Controllers\Api\Member\Village;

use App\Http\Controllers\API\BaseApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageService;

class VillageApiController extends BaseApiController
{
    protected HostRepositoryInterface $host_repository;
    protected VillageRepositoryInterface $village_repository;
    protected VillageService $village_service;

    private Member $member;

    function __construct(
        HostRepositoryInterface $host_repository,
        VillageRepositoryInterface $village_repository
    ) {
        $this->village_service = new VillageService(
            $village_repository,
            $host_repository,
        );
    }

    
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->member = $this->getLoginMember();

        $topic = $this->member->makeVillageTopic($request->title, $request->content, $request->note);
        $setting = $this->member->makeVillageSetting($request->core_member_limit, $request->village_member_limit);
        $requirement = $this->member->makeVillageMemberRequirement($request->requirement);
        $public_info = $this->member->makeVillagePublicInformation($request->nickname_flg, $request->gender_flg, $request->age_flg);

        $phase_start_setting = $this->member->makeVillagePhaseStartSetting(
            false,
            false,
            true,
            null
        );
        $phase_end_setting = $this->member->makeVillagePhaseEndSetting(
            true,
            false,
            null
        );
        // ビレッジ登録
        $village = $this->member->registerVillage(
            $this->village_service,
            $topic, 
            $setting, 
            $requirement, 
            $public_info,
            $phase_start_setting,
            $phase_end_setting,
            new Carbon($request->border_date)
        );
        if(!is_null($village)){
            return $this->makeSuccessResponse([]);
        }else{
            return $this->makeErrorResponse([]);
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
        // ビレッジ取得
        $village_details = $this->village_service->getVillage(new VillageId($id));
        $result = [
            'id' => $village_details->id(),
            'phase' => $village_details->phase()->phase(),
            'phase_status' => $village_details->phase()->phaseStatus(),
            'title' => $village_details->topic()->title(),
            'content' => $village_details->topic()->content(),
            'note' => $village_details->topic()->note(),
            'core_member_limit' => $village_details->setting()->coreMemberLimit(),
            'village_member_limit' => $village_details->setting()->villageMemberLimit(),
            'requirement' => $village_details->requirement()->requirement(),
            'name_flg' => $village_details->publicInformation()->isNicknamePublic(),
            'gender_flg' => $village_details->publicInformation()->isGenderPublic(),
            'age_flg' => $village_details->publicInformation()->isAgePublic(),
        ];
        
        return $this->makeSuccessResponse($result);
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    // }
}
