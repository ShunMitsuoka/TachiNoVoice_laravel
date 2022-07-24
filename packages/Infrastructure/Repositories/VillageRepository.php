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
                'village_member_limit' => $village->setting()->villageMemberLimit(),
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

            $created_phase = ModelPhase::create([
                'village_id' => $village->id(),
                'm_phase_id' => $village->phase()->phase(),
                'm_phase_status_id' => $village->phase()->phaseStatus(),
            ]);
            $created_phase_start_setting = null;
            if($village->phase()->existsPhaseStartSetting()){
                $created_phase_start_setting = ModelPhaseSetting::create([
                    'phase_id' => $created_phase->id,
                    'end_flg' => $village->phase()->phaseStartSetting()->isEndPhase(),
                    'by_manual_flg' => $village->phase()->phaseStartSetting()->byManual(),
                    'by_limit_flg' => $village->phase()->phaseStartSetting()->byLimit(),
                    'by_date_flg' => $village->phase()->phaseStartSetting()->byDate(),
                    'border_date' => $village->phase()->phaseStartSetting()->borderDate(),
                ]);
            }
            $created_phase_end_setting = ModelPhaseSetting::create([
                'phase_id' => $created_phase->id,
                'end_flg' => $village->phase()->phaseEndSetting()->isEndPhase(),
                'by_manual_flg' => $village->phase()->phaseEndSetting()->byManual(),
                'by_limit_flg' => $village->phase()->phaseEndSetting()->byLimit(),
                'by_date_flg' => $village->phase()->phaseEndSetting()->byDate(),
                'border_date' => $village->phase()->phaseEndSetting()->borderDate(),
            ]);

            DB::commit();

            return new Village(
                new VillageId($created_village->id), 
                new VillagePhase(
                    new VillagePhaseId($created_phase->id),
                    $created_phase->m_phase_id,
                    $created_phase->m_phase_status_id,
                    $village->phase()->phaseStartSetting(),
                    $village->phase()->phaseEndSetting()
                ), 
                new Topic(
                    $created_village->title,
                    $created_village->content,
                    $created_village->note,
                ), 
                new VillageSetting(
                    $created_village_setting->village_member_limit,
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