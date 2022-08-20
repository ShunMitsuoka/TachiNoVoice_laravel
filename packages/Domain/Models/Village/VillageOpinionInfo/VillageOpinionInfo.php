<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\Opinion;

class VillageOpinionInfo
{
    private VillageId $village_id;
    private array $opinios;
    private array $categories;

    function __construct(
        VillageId $village_id,
        array $opinios = [],
        array $categories = [],
    ) {
        $this->village_id = $village_id;
        $this->opinios = $opinios;
        $this->categories = $categories;
    }

    public function villageId() : VillageId{
        return $this->village_id;
    }

    public function opinios() : array{
        return $this->opinios;
    }

    public function categories() : array{
        return $this->categories;
    }

    public function addOpinion(Opinion $opinion){
        $this->opinios[] = $opinion;
    }

    public function alreadySaidOpinion(Member $member) : bool{
        
    }

}