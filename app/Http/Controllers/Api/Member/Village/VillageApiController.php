<?php

namespace App\Http\Controllers\Api\Member\Village;

use App\Http\Controllers\API\BaseApiController;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageMemberRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\MemberId;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageService;

class VillageApiController extends BaseApiController
{
    protected VillageService $village_service;

    function __construct(
        VillageService $village_service
    ) {
        $this->village_service = $village_service;
    }


    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index(Request $request)
    {
        //検索文字列を受け取る処理
        $keyword = $request->keyword;
        //SELECT title, content FROM villages WHERE title LIKE '%検索文字列';
        $response = Village::where('title', 'like', '%' . $keyword . '%')->get()->toArray();

        return $this->makeSuccessResponse($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member = $this->getLoginMember();

        $topic = $member->makeVillageTopic($request->title, $request->content, $request->note);
        $setting = $member->makeVillageSetting($request->core_member_limit, $request->village_member_limit);
        $requirement = $member->makeVillageMemberRequirement($request->requirement);
        $public_info = $member->makeVillagePublicInformation($request->nickname_flg, $request->gender_flg, $request->age_flg);

        $phase_start_setting = $member->makeVillagePhaseStartSetting(
            false,
            false,
            true,
            null
        );
        $phase_end_setting = $member->makeVillagePhaseEndSetting(
            true,
            false,
            null
        );
        // ビレッジ登録
        $village = $member->registerVillage(
            $this->village_service,
            $topic,
            $setting,
            $requirement,
            $public_info,
            $phase_start_setting,
            $phase_end_setting,
            new Carbon($request->border_date)
        );
        if (!is_null($village)) {
            return $this->makeSuccessResponse([]);
        } else {
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
            'id' => $village_details->id()->toInt(),
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
            'phase_start_setting' => [
                'end_flg' => $village_details->phase()->phaseStartSetting()->isEndPhase(),
                'by_manual_flg' => $village_details->phase()->phaseStartSetting()->byManual(),
                'by_limit_flg' => $village_details->phase()->phaseStartSetting()->byLimit(),
                'by_date_flg' => $village_details->phase()->phaseStartSetting()->byDate(),
                'border_date' => $village_details->phase()->phaseStartSetting()->borderDate(),
            ],
            'phase_end_setting' => [
                'end_flg' => $village_details->phase()->phaseEndSetting()->isEndPhase(),
                'by_manual_flg' => $village_details->phase()->phaseEndSetting()->byManual(),
                'by_limit_flg' => $village_details->phase()->phaseEndSetting()->byLimit(),
                'by_date_flg' => $village_details->phase()->phaseEndSetting()->byDate(),
                'border_date' => $village_details->phase()->phaseEndSetting()->borderDate(),
            ]
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function join(Request $request)
    {   
        try{
            $member = $this->getLoginMember();
            $success = $this->village_service->joinVillage(new villageId($request->village_id), $member);
            if($success){
                return $this->makeSuccessResponse([]);
            }else{
                return $this->makeErrorResponse([]);
            }
        }catch (\Throwable $e) {
            logs()->error($e->getMessage());
            return $this->makeErrorResponse([$e]);
        }
    }
}
