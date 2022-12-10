<?php

namespace Packages\Domain\Interfaces\Repositories;

use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\VillageDetails\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageId;

interface EvaluationRepositoryInterface
{
    public function getSpecifiedMemberAllEvaluationByVillageId(VillageId $village_id, UserId $user_id) : array;
    public function update(UserId $user_id, Evaluation $evaluation) : bool;

}
