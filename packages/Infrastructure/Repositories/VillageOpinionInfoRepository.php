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
use Packages\Domain\Models\Village\VillageOpinionInfo\Category;
use Packages\Domain\Models\Village\VillageOpinionInfo\CategoryId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Evaluation;
use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion;
use Packages\Domain\Models\Village\VillageOpinionInfo\OpinionId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Policy;
use Packages\Domain\Models\Village\VillageOpinionInfo\Satisfaction;
use Packages\Domain\Models\Village\VillageOpinionInfo\VillageOpinionInfo;

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
                    ->join('users', 'users.id', 'evaluations.user_id')
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
    public function update(VillageOpinionInfo $village_opinion_info) : bool{
        throw new \Exception("Error Processing Request", 1);
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