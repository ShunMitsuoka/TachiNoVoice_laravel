<?php

namespace App\Http\Controllers\Api\Member\MyVillage;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Member\Village\AddCategoryRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillageService;

class CategoryApiController extends BaseApiController
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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCategoryRequest $request, $village_id)
    {
        try {
            DB::beginTransaction();
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            if (!$village->phase()->isPhaseCategorizeOpinions()) {
                throw new Exception('意見カテゴリー分けフェーズではありません', 558);
            }
            $village->setMemberInfo($this->village_service);
            $this->village_details_service->setDetails($village);
            $host = $member->becomeHost($village);
            $host->addCategory($village, $request->category);
            $this->village_details_service->updateDetails($village);
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
    public function update(Request $request, $village_id, $id)
    {
        try {
            DB::beginTransaction();
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            if (!$village->phase()->isPhaseCategorizeOpinions()) {
                throw new Exception('意見カテゴリー分けフェーズではありません', 558);
            }
            $village->setMemberInfo($this->village_service);
            $this->village_details_service->setDetails($village);
            $host = $member->becomeHost($village);
            $host->editCategory($village, new CategoryId($id), $request->category);
            $this->village_details_service->updateDetails($village);
            DB::commit();
            return $this->makeSuccessResponse([]);
        } catch (\Throwable $th) {
            DB::rollBack();
            logs()->error($th->getMessage());
            return $this->makeErrorResponse([$th->getMessage()], $th->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($village_id, $id)
    {
        try {
            DB::beginTransaction();
            $member = $this->getLoginMember();
            $village = $this->village_repository->get(new VillageId($village_id));
            if (!$village->phase()->isPhaseCategorizeOpinions()) {
                throw new Exception('意見カテゴリー分けフェーズではありません', 558);
            }
            $village->setMemberInfo($this->village_service);
            $this->village_details_service->setDetails($village);
            $host = $member->becomeHost($village);
            $host->deleteCategory($village, new CategoryId($id));
            $this->village_details_service->updateDetails($village);
            DB::commit();
            return $this->makeSuccessResponse([]);
        } catch (\Throwable $th) {
            DB::rollBack();
            logs()->error($th->getMessage());
            return $this->makeErrorResponse([$th->getMessage()], $th->getCode());
        }
    }
}
