<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\Phase as ModelPhase;
use App\Models\PhaseSetting as ModelPhaseSetting;
use App\Models\PublicInformation as ModelPublicInformation;
use App\Models\Village as ModelVillage;
use App\Models\VillageMemberRequirement as ModelVillageMemberRequirement;
use App\Models\VillageSetting as ModelVillageSetting;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseSetting;
use Packages\Domain\Models\Village\Topic\Topic;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberRequirement;
use Packages\Domain\Models\Village\VillagePublicInformation;
use Packages\Domain\Models\Village\VillageSetting;

class VillageRepository implements VillageRepositoryInterface
{
    public function save(Village $village) : Village{
        DB::beginTransaction();
        try {
            $created_village = ModelVillage::create([
                'title' => $village->topic()->title(),
                'content' => $village->topic()->content(),
                'note' => $village->topic()->note(),
            ]);
            $village->setId($created_village->id);

            $created_village_setting = ModelVillageSetting::create([
                'village_id' => $village->id(),
                'core_member_limit' => $village->setting()->coreMemberLimit(),
            ]);

            $created_requirement = ModelVillageMemberRequirement::create([
                'village_id' => $village->id(),
                'requirement' => $village->requirement()->requirement(),
            ]);

            $created_public_info = ModelPublicInformation::create([
                'village_id' => $village->id(),
                'nickname_flg' => $village->publicInformation()->isNicknamePublic(),
                'gender_flg' => $village->publicInformation()->isGenderPublic(),
                'age_flg' => $village->publicInformation()->isAgePublic(),
            ]);

            $phase = ModelPhase::create([
                'village_id' => $village->id(),
                'm_phase_id' => $village->phase()->phase(),
                'm_phase_status_id' => $village->phase()->phaseStatus(),
            ]);

            $phase_setting = ModelPhaseSetting::create([
                'phase_id' => $phase->id,
                'end_flg' => $village->phase()->isEndPhase(),
                'by_manual_flg' => $village->phase()->byManual(),
                'by_limit_flg' => $village->phase()->byLimit(),
                'by_date_flg' => $village->phase()->byDate(),
                'border_date' => $village->phase()->borderDate(),
            ]);
            DB::commit();
            return new Village(
                new VillageId($created_village->id), 
                new VillagePhase(
                    new VillagePhaseId($phase->id),
                    $phase->m_phase_id,
                    $phase->m_phase_status_id,
                    new VillagePhaseSetting(
                        $phase_setting->end_flg,
                        $phase_setting->by_manual_flg,
                        $phase_setting->by_limit_flg,
                        $phase_setting->by_date_flg,
                        $phase_setting->border_date,
                    )
                ), 
                new Topic(
                    $created_village->title,
                    $created_village->content,
                    $created_village->note,
                ), 
                new VillageSetting(
                    $created_village_setting->core_member_limit,
                ), 
                new VillageMemberRequirement(
                    $created_requirement->requirement,
                ), 
                new VillagePublicInformation(
                    $created_public_info->nickname_flg,
                    $created_public_info->gender_flg,
                    $created_public_info->age_flg,
                )
            );
        } catch (\Exception $e) {
            DB::rollback();
        }
        return null;
    }
}