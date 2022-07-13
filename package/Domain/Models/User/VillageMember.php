<?php
namespace Packages\Domain\Models\User;

class VillageMember extends Member
{
    
    public function joinVillage():bool {
        return true;
    }

    public function giveAnOpinion()
    {
        # code...
    }
}