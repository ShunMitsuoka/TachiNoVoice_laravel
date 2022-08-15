<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\Category as ModelCategory;
use App\Models\Evaluation as ModelEvaluation;
use App\Models\Opinion as ModelOpinion;
use App\Models\Policy as ModelPolicy;
use App\Models\SatisfactionLevel;
use Carbon\Carbon;
use Packages\Domain\Interfaces\Repositories\VillageOpinionInfoRepositoryInterface;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Category\Category;
use Packages\Domain\Models\Village\VillageOpinionInfo\Category\CategoryId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\Opinion;
use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\OpinionId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Policy\Policy;
use Packages\Domain\Models\Village\VillageOpinionInfo\Satisfaction\Satisfaction;
use Packages\Domain\Models\Village\VillageOpinionInfo\VillageOpinionInfo;
use Packages\Domain\Services\Casts\CategoryCast;
use Packages\Domain\Services\Casts\EvaluationCast;
use Packages\Domain\Services\Casts\OpinionCast;
use Packages\Domain\Services\Casts\SatisfactionCast;

class VillageOpinionInfoRepository implements VillageOpinionInfoRepositoryInterface
{
    public function get(VillageId $village_id) : VillageOpinionInfo{
        $opinions = [];
        $categories = [];
        // opinons作成
        $opinion_records = ModelOpinion::select(
                'opinions.id as opinion_id',
                'category_id',
                'opinion',
                'opinions.user_id',
                'email',
                'user_name',
                'nickname',
                'gender',
                'date_of_birth',
            )
            ->where('opinions.village_id', $village_id->toInt())
            ->notDeleted()
            ->join('users', 'users.id', 'opinions.user_id')
            ->get();
        foreach ($opinion_records as $opinion_record) {
            $evaluation_records = ModelEvaluation::select(
                'evaluations.id',
                'evaluation',
                'opinions.user_id',
                'email',
                'user_name',
                'nickname',
                'gender',
                'date_of_birth',
            )
            ->where('evaluations.opinion_id', $opinion_record->opinion_id)
            ->join('users', 'users.id', 'evaluations.user_id')
            ->get();
            $evaluations = [];
            foreach ($evaluation_records as $evaluation_record) {
                $evaluations[] = new Evaluation(
                    $this->makeMemberFromRecord($evaluation_record),
                    $evaluation_record->evaluation,
                );
            }
            $opinions[] = new Opinion(
                new OpinionId($opinion_record->opinion_id),
                $opinion_record->opinion,
                $this->makeMemberFromRecord($opinion_record),
                $evaluations,
                new CategoryId($opinion_record->category_id),
            );
        }

        // カテゴリー作成
        $category_records = ModelCategory::select(
            'categories.id as category_id',
            'category_name',
        )
        ->where('categories.village_id', $village_id->toInt())
        ->notDeleted()
        ->get();
        foreach ($category_records as $category_record) {
            $policy_record = ModelPolicy::where('category_id', $category_record->category_id)->first();
            $policy = null;
            if(!is_null($policy_record)){
                $satisfaction_records = SatisfactionLevel::select(
                        'satisfaction_levels.id',
                        'satisfaction_level',
                        'comment',
                        'satisfaction_levels.user_id',
                        'email',
                        'user_name',
                        'nickname',
                        'gender',
                        'date_of_birth',
                    )
                    ->where('policy_id', $policy_record->id)
                    ->join('users', 'users.id', 'satisfaction_levels.user_id')
                    ->get();
                $satisfactions = [];
                foreach ($satisfaction_records as $satisfaction_record) {
                    $satisfactions[] = new Satisfaction(
                        $this->makeMemberFromRecord($satisfaction_record),
                        $satisfaction_record->satisfaction_level,
                        $satisfaction_record->comment,
                    );
                }
                $policy = new Policy(
                    $policy_record->policy,
                    $satisfactions,
                );
            }
            $categories[] = new Category(
                new CategoryId($category_record->category_id),
                $category_record->category_name,
                $policy
            );
        }
        return new VillageOpinionInfo(
            $village_id,
            $opinions,
            $categories,
        );
    }

    /**
     * 
     */
    public function update(VillageOpinionInfo $village_opinion_info) : VillageOpinionInfo{
        $village_id = $village_opinion_info->villageId();
        $categories = $village_opinion_info->categories();
        $category_ids = [];
        foreach ($categories as $category) {
            // カテゴリー保存
            $category = CategoryCast::castCategory($category);
            if($category->existsId()){
                $category_ids[] = $category->id()->toInt();
                ModelCategory::where('id', $category->id()->toInt())
                    ->update([
                        'village_id' => $village_id->toInt(),
                        'category_name' => $category->name(),
                    ]);
            }else{
                $created_category = ModelCategory::create([
                    'village_id' => $village_id->toInt(),
                    'category_name' => $category->name(),
                ]);
                $category->setId($created_category->id);
            }
            // 方針保存
            if($category->existsPolicy()){
                $policy = $category->policy();
                $policy_record = ModelPolicy::updateOrCreate([
                    'category_id' => $category->id()->toInt(),
                ],[
                    'category_id' => $category->id()->toInt(),
                    'policy' => $policy->content(),
                ]);
                $satisfactions = $policy->satisfactions();
                foreach ($satisfactions as $satisfaction) {
                    $satisfaction = SatisfactionCast::castSatisfaction($satisfaction);
                    SatisfactionLevel::updateOrCreate([
                        'user_id' => $satisfaction->member()->id()->toInt(),
                        'policy_id' => $policy_record->id,
                    ],[
                        'user_id' => $satisfaction->member()->id()->toInt(),
                        'policy_id' => $policy_record->id,
                        'satisfaction_level' => $satisfaction->level(),
                        'comment' => $satisfaction->comment(),
                    ]);
                }
            }
        }
        // 削除されたカテゴリーは削除する。
        ModelCategory::where('village_id', $village_id->toInt())
            ->whereNotIn('id', $category_ids)
            ->update([
                'deleted_flg' => true
            ]);

        // 意見保存
        $opinions = $village_opinion_info->opinios();
        foreach ($opinions as $opinion) {
            $opinion = OpinionCast::castOpinion($opinion);
            if($opinion->existsId()){
                ModelOpinion::where('id', $opinion->id()->toInt())
                    ->update([
                        'category_id' => $opinion->categoryId()->toInt(),
                        'opinion' => $opinion->content(),
                    ]);
            }else{
                $created_opinion = ModelOpinion::create([
                    'village_id' => $village_id->toInt(),
                    'user_id' => $opinion->member()->id()->toInt(),
                    'category_id' => $opinion->existsCategoryId() ? $opinion->categoryId()->toInt() : null,
                    'opinion' => $opinion->content(),
                ]);
                $opinion->setId($created_opinion->id);
            }
            # code...
            $evaluations = $opinion->evaluations();
            foreach ($evaluations as $evaluation) {
                $evaluation = EvaluationCast::castEvaluation($evaluation);
                ModelEvaluation::updateOrCreate([
                    'opinion_id' => $opinion->id()->toInt(),
                    'user_id' => $evaluation->member()->id()->toInt(),
                ],[
                    'opinion_id' => $opinion->id()->toInt(),
                    'user_id' => $evaluation->member()->id()->toInt(),
                    'evaluation' => $evaluation->value(),
                ]);
            }
        }
        return $village_opinion_info;
    }

    private function makeMemberFromRecord($record) : Member{
        return new Member(
            new UserId($record->user_id),
            $record->user_name,
            $record->nickname,
            $record->email,
            new Gender($record->gender),
            new Carbon($record->date_of_birth),
        );
    }
}