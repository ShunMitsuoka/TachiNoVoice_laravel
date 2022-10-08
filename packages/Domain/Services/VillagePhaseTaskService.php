<?php
namespace Packages\Domain\Services;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Services\Casts\CategoryCast;
use Packages\Domain\Services\Casts\OpinionCast;

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
            case VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                if($role_id == Member::ROLE_RISE_MEMBER){
                    $rise_member = $member->becomeRiseMember($village);
                    $categories = $village->categories();
                    $opinions = $rise_member->opinions();
                    $is_done = true;
                    foreach ($categories as $category) {
                        $category = CategoryCast::castCategory($category);
                        $exist_flg = false;
                        foreach ($opinions as $opinion) {
                            $opinion = OpinionCast::castOpinion($opinion);
                            if($opinion->categoryId()->toInt() == $category->id()->toInt()){
                                $exist_flg = true;
                                break;
                            }
                        }
                        if(!$exist_flg){
                            $is_done = false;
                        }
                    }
                    return $is_done;
                }
                break;
            default:
                # code...
                break;
        }
        return false;
    }

}