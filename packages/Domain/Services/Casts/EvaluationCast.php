<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Village\VillageDetails\Evaluation\Evaluation;

class EvaluationCast{
    static public function castEvaluation($evaluation) : Evaluation{
        return $evaluation;
    }
}