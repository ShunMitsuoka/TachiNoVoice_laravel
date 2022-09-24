<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\Category as ModelCategory;
use App\Models\Evaluation as ModelEvaluation;
use App\Models\Opinion as ModelOpinion;
use App\Models\Policy as ModelPolicy;
use App\Models\Review as ModelReview;
use App\Models\SatisfactionLevel;
use Packages\Domain\Models\Village\VillageDetails\Review\Review;
use Packages\Domain\Interfaces\Repositories\VillageDetailsRepositoryInterface;
use Packages\Domain\Models\User\VillageMember;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageDetails\Category\Category;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;
use Packages\Domain\Models\Village\VillageDetails\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageDetails\Opinion\Opinion;
use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;
use Packages\Domain\Models\Village\VillageDetails\Policy\Policy;
use Packages\Domain\Models\Village\VillageDetails\Policy\PolicyId;
use Packages\Domain\Models\Village\VillageDetails\Satisfaction\Satisfaction;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\Casts\CategoryCast;
use Packages\Domain\Services\Casts\EvaluationCast;
use Packages\Domain\Services\Casts\MemberCast;
use Packages\Domain\Services\Casts\OpinionCast;
use Packages\Domain\Services\Casts\SatisfactionCast;
class VillageDetailsRepository implements VillageDetailsRepositoryInterface
{
    public function get(Village $village): Village
    {
        $village_id = $village->id();
        $member_info = $village->memberInfo();
        // カテゴリーとポリシー取得
        $category_records = ModelCategory::select(
            'categories.id as category_id',
            'category_name',
        )
        ->where('categories.village_id', $village_id->toInt())
        ->notDeleted()
        ->get();
        $categories = [];
        foreach ($category_records as $category_record) {
            $policy_record = ModelPolicy::where('category_id', $category_record->category_id)->first();
            $policy = null;
            if(!is_null($policy_record)){
                $policy = new Policy(
                    new PolicyId($policy_record->id),
                    $policy_record->policy,
                );
            }
            $categories[] = new Category(
                new CategoryId($category_record->category_id),
                $category_record->category_name,
                $policy
            );
        }
        $village->topic()->setCategories($categories);
        // メンバーに意見、評価、レビューを設定
        $core_members = $member_info->coreMembers();
        $rise_members = $member_info->riseMembers();
        foreach ($core_members as $core_member) {
            $this->getDetailsOfMember($village_id, $core_member);
        }
        foreach ($rise_members as $rise_member) {
            $this->getDetailsOfMember($village_id, $rise_member);
        }
        return $village;
    }

    public function update(Village $village): bool
    {
        $village_id = $village->id();
        $categories = $village->topic()->categories();
        $category_ids = [];
        foreach ($categories as $category) {
            // カテゴリー保存
            $category = CategoryCast::castCategory($category);
            if($category->existsId()){
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
            $category_ids[] = $category->id()->toInt();
            // 方針保存
            if($category->existsPolicy()){
                $policy = $category->policy();
                ModelPolicy::updateOrCreate([
                    'category_id' => $category->id()->toInt(),
                ],[
                    'category_id' => $category->id()->toInt(),
                    'policy' => $policy->content(),
                ]);
            }
        }
        // 削除されたカテゴリーは削除する。
        ModelCategory::where('village_id', $village_id->toInt())
            ->whereNotIn('id', $category_ids)
            ->update([
                'deleted_flg' => true
            ]);
        $member_info = $village->memberInfo();
        $core_members = $member_info->coreMembers();
        $rise_members = $member_info->riseMembers();
        foreach ($core_members as $member) {
            $this->updateDetailsOfMember($village_id, $member);
        }
        foreach ($rise_members as $member) {
            $this->updateDetailsOfMember($village_id, $member);
        }
        return true;
    }

    private function getDetailsOfMember(VillageId $village_id ,VillageMember $member){
        $member = MemberCast::castVillageMember($member);
        $user_id = $member->id();
        // 意見
        $opinion_records = ModelOpinion::select(
            'opinions.id as opinion_id',
            'category_id',
            'opinion'
        )
        ->where('opinions.village_id', $village_id->toInt())
        ->where('opinions.user_id', $user_id->toInt())
        ->notDeleted()
        ->get();
        $opinions = [];
        foreach ($opinion_records as $opinion_record) {
            $opinions[] = new Opinion(
                new OpinionId($opinion_record->opinion_id),
                $opinion_record->opinion,
                is_null($opinion_record->category_id) ? null : new CategoryId($opinion_record->category_id),
            );
        }
        $member->setOpinions($opinions);
        // 評価
        $evaluation_records = ModelEvaluation::select(
            'evaluations.id',
            'evaluations.opinion_id',
            'evaluation',
        )
        ->join('opinions', 'opinions.id', 'evaluations.opinion_id')
        ->where('opinions.village_id', $village_id->toInt())
        ->where('evaluations.user_id', $user_id->toInt())
        ->get();
        $evaluations = [];
        foreach ($evaluation_records as $evaluation_record) {
            $evaluations[] = new Evaluation(
                new OpinionId($evaluation_record->opinion_id),
                $evaluation_record->evaluation,
            );
        }
        $member->setEvaluations($evaluations);
        // レビュー
        $review_record = ModelReview::select(
            'comment',
        )
        ->where('village_id', $village_id->toInt())
        ->where('user_id', $user_id->toInt())
        ->first();
        if(!is_null($review_record)){
            $satisfaction_records = SatisfactionLevel::select(
                'satisfaction_levels.id',
                'satisfaction_level.policy_id',
                'satisfaction_level',
            )
            ->where('review_id', $review_record->id)
            ->get();
            $satisfactions = [];
            foreach ($satisfaction_records as $satisfaction_record) {
                $satisfactions[] = new Satisfaction(
                    new PolicyId($satisfaction_record->policy_id),
                    $satisfaction_record->satisfaction_level
                );
            }
            $member->setReview(new Review(
                $satisfactions,
                $review_record->comment
            ));
        }
    }

    private function updateDetailsOfMember(VillageId $village_id ,VillageMember $member){
        $member = MemberCast::castVillageMember($member);
        $user_id = $member->id();
        $opinions = $member->opinions();
        foreach ($opinions as $opinion) {
            $opinion = OpinionCast::castOpinion($opinion);
            if($opinion->existsId()){
                ModelOpinion::where('id', $opinion->id()->toInt())
                ->update([
                    'category_id' => $opinion->existsCategoryId() ? $opinion->categoryId()->toInt() : null,
                ]);
            }else{
                $created_opinion = ModelOpinion::create([
                    'village_id' => $village_id->toInt(),
                    'user_id' => $user_id->toInt(),
                    'category_id' => $opinion->existsCategoryId() ? $opinion->categoryId()->toInt() : null,
                    'opinion' => $opinion->content(),
                ]);
                $opinion->setId($created_opinion->id);
            }
        }
        $evaluations = $member->evaluations();
        foreach ($evaluations as $evaluation) {
            $evaluation = EvaluationCast::castEvaluation($evaluation);
            ModelEvaluation::updateOrCreate([
                'opinion_id' => $evaluation->opinionId()->toInt(),
                'user_id' => $user_id->toInt(),
            ],[
                'opinion_id' => $evaluation->opinionId()->toInt(),
                'user_id' => $user_id->toInt(),
                'evaluation' => $evaluation->value(),
            ]);
        }
        if($member->hasReview()){
            $review = $member->review();
            $review_record = ModelReview::updateOrCreate([
                'village_id' => $village_id->toInt(),
                'user_id' => $user_id->toInt(),
            ],[
                'village_id' => $village_id->toInt(),
                'user_id' => $user_id->toInt(),
                'comment' => $review->comment(),
            ]);
            $satisfactions = $review->satisfactions();
            foreach ($satisfactions as $satisfaction) {
                $satisfaction = SatisfactionCast::castSatisfaction($satisfaction);
                SatisfactionLevel::updateOrCreate([
                    'review_id' => $review_record->id,
                    'policy_id' => $satisfaction->policyId()->toInt(),
                ],[
                    'review_id' => $review_record->id,
                    'policy_id' => $satisfaction->policyId()->toInt(),
                    'satisfaction_level' => $satisfaction->level(),
                ]);
            }
        }
    }
}
