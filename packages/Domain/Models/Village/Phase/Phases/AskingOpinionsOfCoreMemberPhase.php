<?php
namespace Packages\Domain\Models\Village\Phase\Phases;

use Packages\Domain\Models\Village\Phase\EndSettingInfo;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseEndSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhaseSettingItem;

class AskingOpinionsOfCoreMemberPhase extends VillagePhase
{
    protected bool $is_necessary_to_set_phase_start_setting = false;
    protected bool $is_necessary_to_set_phase_end_setting = true;

    function __construct(
        ?VillagePhaseId $id,
        int $phase_no,
        int $phase_status,
        ?VillagePhaseEndSetting $phase_end_setting,
    ) {
        if($phase_no !== self::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER){
            throw new \Exception("異なるフェーズが設定されました。", 1);
        }
        parent::__construct($id, $phase_no, $phase_status, null, $phase_end_setting);
        $this->phase_name = self::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER_NAME;
        $this->end_setting_info = new EndSettingInfo(
            new VillagePhaseSettingItem(
                true, '手動で終了する。', $this->getEndSetting($phase_end_setting)->byManualFlg()
            ),
            new VillagePhaseSettingItem(
                true, '募集終了日を設定する。', $this->getEndSetting($phase_end_setting)->byDateFlg(), $this->getEndSetting($phase_end_setting)->borderDate()
            ),
            new VillagePhaseSettingItem(
                true, '全員が意見した場合終了する。', $this->getEndSetting($phase_end_setting)->byLimitFlg()
            )
        );
    }
}