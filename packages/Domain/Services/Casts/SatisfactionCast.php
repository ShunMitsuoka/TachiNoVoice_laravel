<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Models\Village\VillageDetails\Satisfaction\Satisfaction;

class SatisfactionCast{
    static public function castSatisfaction($satisfaction) : Satisfaction{
        return $satisfaction;
    }
}