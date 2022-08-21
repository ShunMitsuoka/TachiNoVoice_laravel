<?php
namespace Packages\Domain\Services;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Village;

class VillagePhaseTaskService{

    static public function isTaskDone(Village $village, Member $member) : bool{
        $role_id = $village->getMemberRole($member);
        switch ($village->phase()->phaseNo()) {
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                if($role_id == Member::ROLE_CORE_MEMBER){
                    $core_member = $member->becomeCoreMember($village);
                    return count($core_member->opinions()) > 0;
                }
                break;
            default:
                # code...
                break;
        }
        return false;
    }

}