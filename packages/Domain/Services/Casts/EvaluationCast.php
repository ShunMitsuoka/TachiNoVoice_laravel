<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Models\Village\VillageOpinionInfo\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\Opinion;

class EvaluationCast{
    static public function castEvaluation($evaluation) : Evaluation{
        return $evaluation;
    }
}