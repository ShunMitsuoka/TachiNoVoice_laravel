<?php

namespace App\Http\Controllers\Api\Member\Village;

use App\Http\Controllers\API\BaseApiController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\MemberId;
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

        $user = auth()->user();
        $this->member = new Member(
            new MemberId($user->id),
            $user->user_name,
            $user->nickname,
            $user->email,
            $user->gender,
            $user->date_of_birth,
        );

        $topic = $this->member->makeVillageTopic($request->title, $request->content, $request->note);
        $setting = $this->member->makeVillageSetting($request->core_member_limit);
        $requirement = $this->member->makeVillageMemberRequirement($request->requirement);
        $public_info = $this->member->makeVillagePublicInformation($request->nickname_flg, $request->gender_flg, $request->age_flg);
        // ビレッジ登録
        $village = $this->member->registerVillage(
            $this->village_service,
            $topic, 
            $setting, 
            $requirement, 
            $public_info,
            $request->by_manual_flg,
            $request->by_limit_flg,
            $request->by_date_flg,
            $request->by_instant_flg,
            new Carbon($request->border_date)
        );
        if(!is_null($village)){
            $this->makeSuccessResponse([]);
        }else{
            $this->makeErrorResponse([]);
        }
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

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
