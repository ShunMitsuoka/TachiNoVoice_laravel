<?php

namespace Packages\Infrastructure\Repositories;

use Packages\Domain\Interfaces\Repositories\EvaluationRepositoryInterface;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\VillageId;
use App\Models\Evaluation as ModelEvaluation;
use Packages\Domain\Models\Village\VillageDetails\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;

class EvaluationRepository implements EvaluationRepositoryInterface
{
    public function getSpecifiedMemberAllEvaluationByVillageId(VillageId $village_id, UserId $user_id) : array
    {
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
        return $evaluations;
    }

    public function update(UserId $user_id, Evaluation $evaluation) : bool
    {
        ModelEvaluation::updateOrCreate([
            'opinion_id' => $evaluation->opinionId()->toInt(),
            'user_id' => $user_id->toInt(),
        ],[
            'opinion_id' => $evaluation->opinionId()->toInt(),
            'user_id' => $user_id->toInt(),
            'evaluation' => $evaluation->value(),
        ]);
        return true;
    }

}