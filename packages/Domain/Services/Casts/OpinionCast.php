<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Models\Village\VillageDetails\Opinion\Opinion;

class OpinionCast{
    static public function castOpinion($opinion) : Opinion{
        return $opinion;
    }
}