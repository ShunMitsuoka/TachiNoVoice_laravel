<?php

namespace App\Http\Controllers\Api\Member\Village;

use App\Http\Controllers\API\BaseApiController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Models\User\Host;

class VillageApiController extends BaseApiController
{
    protected HostRepositoryInterface $host_repository;

    private Host $host;

    function __construct(HostRepositoryInterface $host_repository) {
        $this->host = $host_repository->get(1);
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
        $topic = $this->host->makeVillageTopic($request->title, $request->content, $request->note);
        $setting = $this->host->makeVillageSetting($request->core_member_limit);
        $requirement = $this->host->makeVillageMemberRequirement($request->requirement);
        $public_info = $this->host->makeVillagePublicInformation($request->nickname_flg, $request->gender_flg, $request->age_flg);
        // ビレッジ登録
        $village = $this->host->registerVillage(
            $topic, 
            $setting, 
            $requirement, 
            $public_info,
            $request->by_manual_flg,
            $request->by_limit_flg,
            $request->by_date_flg,
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
