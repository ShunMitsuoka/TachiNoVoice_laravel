<?php

namespace App\Services;

use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\Village;

class VillageApiResponseService
{

    static public function villageResponse(
        Village $village,
        Member $member = null,
    ) {
        $result = [
            'village_id' => $village->id()->toInt(),
            'phase_no' => $village->phase()->phaseNo(),
            'phase_name' => $village->phase()->phaseName(),
            'phase_status' => $village->phase()->phaseStatus(),
            'title' => $village->topic()->title(),
            'content' => $village->topic()->content(),
            'note' => $village->topic()->note(),
            'core_member_limit' => $village->setting()->coreMemberLimit(),
            'village_member_limit' => $village->setting()->villageMemberLimit(),
            'is_phase_preparing' => $village->phase()->isReady(),
            'exists_phase_start_setting' => $village->phase()->existsPhaseStartSetting(),
            'exists_phase_end_setting' => $village->phase()->existsPhaseEndSetting(),
            'is_necessary_to_set_phase_setting' => $village->phase()->isNecessaryToSetPhaseSetting(),
            'is_necessary_to_set_phase_start_setting' => $village->phase()->isNecessaryToSetPhaseStartSetting(),
            'is_necessary_to_set_phase_end_setting' => $village->phase()->isNecessaryToSetPhaseEndSetting(),
        ];
        if ($village->existsMemberInfo()) {
            $result['village_member_count'] = $village->memberInfo()->getVillageMemberCount();
            $result['core_member_count'] = $village->memberInfo()->getCoreMemberCount();
            $result['rise_member_count'] = $village->memberInfo()->getRiseMemberCount();
        }
        if (!is_null($member)) {
            $result['role_id'] = $village->getMemberRole($member);
        }
        return $result;
    }
}
