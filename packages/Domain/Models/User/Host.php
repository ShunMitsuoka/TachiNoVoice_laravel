<?php

namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\User\UserInfo\Gender;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageDetails\Category\Category;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;
use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;
use Packages\Domain\Models\Village\VillageDetails\Policy\Policy;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Services\Casts\CategoryCast;
use Packages\Domain\Services\Casts\MemberCast;
use Packages\Domain\Services\Casts\OpinionCast;

class Host extends Member
{
    protected VillageId $village_id;

    function __construct(
        VillageId $village_id,
        UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        Gender $gender,
        Carbon $date_of_birth,
    ) {
        parent::__construct($id, $name, $nickname, $email, $gender, $date_of_birth);
        $this->village_id = $village_id;
        $this->role_id = self::ROLE_HOST;
    }

    public function addCategory(Village $village, string $category){
        $village->topic()->addCategory(new Category(
            null, $category, null
        ));
    }

    public function editCategory(Village $village, CategoryId $category_id, string $category_name){
        $categories = $village->topic()->categories();
        foreach ($categories as $category) {
            $category = CategoryCast::castCategory($category);
            if($category->id()->toInt() == $category_id->toInt() ){
                $category->setName($category_name);
                break;
            }
        }
    }

    public function setCategoryToOpinion(Village $village, CategoryId $category_id, UserId $user_id , OpinionId $opinion_id){
        $core_members = $village->memberInfo()->coreMembers();
        $core_member = MemberCast::castCoreMember($core_members[$user_id->toInt()]);
        foreach ($core_member->opinions() as $opinion) {
            $opinion = OpinionCast::castOpinion($opinion);
            if($opinion->id()->toInt() === $opinion_id->toInt()){
                $opinion->setCategoryId($category_id);
                return;
            }
        }
    }

    public function setPolicy(Village $village, CategoryId $category_id, Policy $policy)
    {
        $category = $village->topic()->getCategory($category_id);
        $category->setPolicy($policy);
    }
}
