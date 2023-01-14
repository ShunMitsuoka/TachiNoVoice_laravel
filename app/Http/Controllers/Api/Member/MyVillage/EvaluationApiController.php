<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\EvaluationRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageDetails\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\Casts\EvaluationCast;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillageService;

class EvaluationApiController extends BaseApiController
{
    protected VillageService $village_service;
    protected VillageDetailsService $village_details_service;
    protected VillageRepositoryInterface $village_repository;
    protected EvaluationRepositoryInterface $evaluation_repository;

    function __construct(
        VillageService $village_service,
        VillageDetailsService $village_details_service,
        VillageRepositoryInterface $village_repository,
        EvaluationRepositoryInterface $evaluation_repository,
    ) {
        $this->village_service = $village_service;
        $this->village_details_service = $village_details_service;
        $this->village_repository = $village_repository;
        $this->evaluation_repository = $evaluation_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $village_id)
    {
        $member = $this->getLoginMember();
        $evaluations = $this->evaluation_repository->getSpecifiedMemberAllEvaluationByVillageId(new VillageId($village_id), $member->id());
        $result = [];
        foreach ($evaluations as $evaluation) {
            $evaluation = EvaluationCast::castEvaluation($evaluation);
            $result[] = [
                'opinion_id' => $evaluation->opinionId()->toInt(),
                'value' => $evaluation->value()
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $village_id)
    {
        try {
            DB::beginTransaction();
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            if (!$village->phase()->isPhaseEvaluation()) {
                throw new Exception("意見評価フェーズではありません", 558);
            }
            $village->setMemberInfo($this->village_service);
            // メンバーの参加確認
            $village_member = $member->becomeVillageMember($village);
            // 意見の追加・更新
            $evaluation = new Evaluation(new OpinionId($request->opinion_id), $request->value);
            $this->evaluation_repository->update($member->id(), $evaluation);
            DB::commit();
            return $this->makeSuccessResponse([]);
        } catch (\Throwable $th) {
            DB::rollBack();
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
