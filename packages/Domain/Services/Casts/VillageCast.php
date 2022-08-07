<?php
namespace Packages\Domain\Services\Casts;

use Packages\Domain\Models\Village\Village;

class VillageCast{

    static public function castVillage($village) : Village{
        return $village;
    }

}