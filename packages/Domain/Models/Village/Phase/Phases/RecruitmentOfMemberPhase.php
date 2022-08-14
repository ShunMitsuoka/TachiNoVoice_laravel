<?php
namespace Packages\Domain\Models\Village\Phase\Phases;

use Packages\Domain\Models\Village\Phase\EndSettingInfo;
use Packages\Domain\Models\Village\Phase\StartSettingInfo;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseEndSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseSettingItem;
use Packages\Domain\Models\Village\Phase\VillagePhaseStartSetting;

class RecruitmentOfMemberPhase extends VillagePhase
{
    function __construct(
        ?VillagePhaseId $id,
        int $phase_no,
        int $phase_status,
        ?VillagePhaseStartSetting $phase_start_setting,
        ?VillagePhaseEndSetting $phase_end_setting,
    ) {
        if($phase_no !== self::PHASE_RECRUITMENT_OF_MEMBER){
            throw new \Exception("異なるフェーズが設定されました。", 1);
        }
        parent::__construct($id, $phase_no, $phase_status, $phase_start_setting, $phase_end_setting);
        $this->phase_name = self::PHASE_RECRUITMENT_OF_MEMBER_NAME;

        $this->start_setting_info = new StartSettingInfo(
            new VillagePhaseSettingItem(
                true, '手動で開始する。', $this->getStartSetting($phase_start_setting)->byManualFlg()
            ),
            new VillagePhaseSettingItem(
                true, '募集開始日を設定する', $this->getStartSetting($phase_start_setting)->byDateFlg(), $this->getStartSetting($phase_start_setting)->borderDate()
            ),
            new VillagePhaseSettingItem(
                true, 'ビレッジ作成後、即時募集開始', $this->getStartSetting($phase_start_setting)->byInstantFlg()
            )
        );

        $this->end_setting_info = new EndSettingInfo(
            new VillagePhaseSettingItem(
                true, '手動で終了する。', $this->getEndSetting($phase_end_setting)->byManualFlg()
            ),
            new VillagePhaseSettingItem(
                true, '募集終了日を設定する。', $this->getEndSetting($phase_end_setting)->byDateFlg(), $this->getEndSetting($phase_end_setting)->borderDate()
            ),
            new VillagePhaseSettingItem(
                true, '定員になり次第終了する。', $this->getEndSetting($phase_end_setting)->byLimitFlg()
            )
        );
    }

    public function isNecessaryToSetPhaseSetting() : bool{
        return true;
    }
    public function isNecessaryToSetPhaseStartSetting() : bool{
        return true;
    }
    public function isNecessaryToSetPhaseEndSetting() : bool{
        return true;
    }
}