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
            'exists_phase_setting' => $village->phase()->existsPhaseSetting(),
            'exists_phase_start_setting' => $village->phase()->existsPhaseStartSetting(),
            'exists_phase_end_setting' => $village->phase()->existsPhaseEndSetting(),
            'is_necessary_to_set_phase_setting' => $village->phase()->isNecessaryToSetPhaseSetting(),
            'is_necessary_to_set_phase_start_setting' => $village->phase()->isNecessaryToSetPhaseStartSetting(),
            'is_necessary_to_set_phase_end_setting' => $village->phase()->isNecessaryToSetPhaseEndSetting(),
        ];
        $result['phase_start_setting'] = [];
        if($village->phase()->isNecessaryToSetPhaseStartSetting()){
            $result['phase_start_setting'] = [
                'by_manual' => [
                    'is_need' => $village->phase()->startSettingInfo()->byManual()->isNeed(),
                    'label' => $village->phase()->startSettingInfo()->byManual()->label(),
                    'is_selected' => $village->phase()->startSettingInfo()->byManual()->isSelected(),
                ],
                // 'by_date' => $village->phase()->phaseStartSetting()->byDateFlg(),
                // 'by_instant' => $village->phase()->phaseStartSetting()->byInstantFlg(),
                // 'border_date' => $village->phase()->phaseStartSetting()->borderDate(),
            ];
        }
        $result['phase_end_setting'] = [];
        if($village->phase()->isNecessaryToSetPhaseEndSetting()){
            $result['phase_end_setting'] = [
                'by_manual' => [
                    'is_need' => $village->phase()->endSettingInfo()->byManual()->isNeed(),
                    'label' => $village->phase()->endSettingInfo()->byManual()->label(),
                    'is_selected' => $village->phase()->endSettingInfo()->byManual()->isSelected(),
                    // 'date' => $village->phase()->endSettingInfo()->byManual()->date(),
                ],
                // 'by_limit' => $village->phase()->phaseEndSetting()->byLimitFlg(),
                // 'by_date' => $village->phase()->phaseEndSetting()->byDateFlg(),
                // 'border_date' => $village->phase()->phaseEndSetting()->borderDate(),
            ];
        }
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
