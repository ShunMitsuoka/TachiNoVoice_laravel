<?php

namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\Village\VillageDetails\Review\Review;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\VillageDetails\Evaluation\Evaluation;
use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\Casts\EvaluationCast;

class VillageMember extends Member
{
    protected VillageId $village_id;
    protected array $opinions;
    protected array $evaluations;
    protected ?Review $review;

    function __construct(
        VillageId $village_id,
        UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        Gender $gender,
        Carbon $date_of_birth,
        array $opinions = [],
        array $evaluations = [],
        ?Review $review = null,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth, $opinions, $evaluations, $review);
        $this->village_id = $village_id;
        $this->role_id = self::ROLE_VILLAGE_MEMBER;
        $this->opinions = $opinions;
        $this->evaluations = $evaluations;
        $this->review = $review;
    }

    public function isVillageMember()
    {
        return $this->role_id === self::ROLE_VILLAGE_MEMBER;
    }

    public function isCoreMember()
    {
        return $this->role_id === self::ROLE_CORE_MEMBER;
    }

    public function isRiseMember()
    {
        return $this->role_id === self::ROLE_RISE_MEMBER;
    }

    public function role(): int
    {
        return $this->role_id;
    }

    public function opinions(): array
    {
        return $this->opinions;
    }
    public function setOpinions(array $opinions)
    {
        $this->opinions = $opinions;
    }

    public function evaluations(): array
    {
        return $this->evaluations;
    }

    public function setEvaluations(array $evaluations)
    {
        $this->evaluations = $evaluations;
    }

    public function review(): Review
    {
        return $this->review;
    }

    public function setReview(Review $review)
    {
        $this->review = $review;
    }

    public function hasReview(): bool
    {
        return !is_null($this->review);
    }

    public function evaluate(OpinionId $opinion_id, int $value){
        for ($i=0; $i < count($this->evaluations) ; $i++) { 
            $evaluation = EvaluationCast::castEvaluation($this->evaluations[$i]);
            if($evaluation->opinionId()->toInt() == $opinion_id->toInt()){
                $this->evaluations[$i] = new Evaluation($opinion_id, $value);
                return;
            }
        }
        $this->evaluations[] = new Evaluation($opinion_id, $value);
        return;
    }
}
