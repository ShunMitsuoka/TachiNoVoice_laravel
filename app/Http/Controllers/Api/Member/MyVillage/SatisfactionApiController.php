<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use App\Services\VillageApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;
use Packages\Domain\Models\Village\VillageDetails\Policy\PolicyId;
use Packages\Domain\Models\Village\VillageDetails\Review\Review;
use Packages\Domain\Models\Village\VillageDetails\Satisfaction\Satisfaction;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillageService;

class SatisfactionApiController extends BaseApiController
{
    protected VillageService $village_service;
    protected VillageDetailsService $village_details_service;
    protected VillageRepositoryInterface $village_repository;

    function __construct(
        VillageService $village_service,
        VillageDetailsService $village_details_service,
        VillageRepositoryInterface $village_repository,
    ) {
        $this->village_service = $village_service;
        $this->village_details_service = $village_details_service;
        $this->village_repository = $village_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $village_id)
    {
        try {
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            $village->setMemberInfo($this->village_service);
            $this->village_details_service->setDetails($village);
            $result = VillageApiResponseService::villageResultResponse($village, $member);
            return $this->makeSuccessResponse($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $village_id)
    {
        $req_comment = $request->filled('comment') ? $request->comment : null;
        $req_satisfactions = $request->satisfactions;
        $satisfactions = [];
        foreach ($req_satisfactions as $req_satisfaction) {
            $satisfactions[] = new Satisfaction(new PolicyId($req_satisfaction['policy_id']), $req_satisfaction['level']);
        }
        $review = new Review($satisfactions, $req_comment, $request->comment_public_flg);
        try {
            DB::beginTransaction();
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            if (!$village->phase()->isPhaseSurveyingSatisfaction()) {
                throw new Exception("満足度調査フェーズではありません", 558);
            }
            if ($village->isFinished()) {
                throw new Exception("既にこのビレッジは終了しています", 558);
            }
            $village->setMemberInfo($this->village_service);
            $this->village_details_service->setDetails($village);
            $village_member = $member->becomeVillageMember($village);
            $village_member->setReview($review);
            $this->village_details_service->updateDetails($village);
            DB::commit();
            return $this->makeSuccessResponse([]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            logs()->error($th->getMessage());
            return $this->makeErrorResponse([$th->getMessage()], $th->getCode());
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
