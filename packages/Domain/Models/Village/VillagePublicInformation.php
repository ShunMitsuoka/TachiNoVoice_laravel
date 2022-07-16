<?php
namespace Packages\Domain\Models\Village;

class VillagePublicInformation
{
    private bool $nickname_flg;
    private bool $gender_flg;
    private bool $age_flg;

    function __construct(
        bool $nickname_flg,
        bool $gender_flg,
        bool $age_flg,
    ) {
        $this->nickname_flg = $nickname_flg;
        $this->gender_flg = $gender_flg;
        $this->age_flg = $age_flg;
    }

    public function isNicknamePublic() : bool{
        return $this->nickname_flg;
    }

    public function isGenderPublic() : bool{
        return $this->gender_flg;
    }

    public function isAgePublic() : bool{
        return $this->age_flg;
    }

}