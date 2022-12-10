<?php
namespace Packages\Infrastructure\Services;

use App\Mail\EndPhaseEmail;
use App\Mail\NextPhaseEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Packages\Domain\Interfaces\Services\SendNextPhaseEmailServiceInterface;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Services\Casts\MemberCast;
use Packages\Infrastructure\Apis\PythonApi;

class SendNextPhaseEmailService implements SendNextPhaseEmailServiceInterface
{
    public function sendNextPhaseEmail(Village $village) : bool
    {
        if ($village->existsMemberInfo()) {
            $village_member_array = $village->memberInfo()->villageMembers();
            $host_array = $village->memberInfo()->hosts();
            $core_member_array = $village->memberInfo()->coreMembers();
            $rise_member_array = $village->memberInfo()->riseMembers();
            $url = config('app.url');
            $url = $url."/member/village/my/details/".$village->id()->toInt();

            switch ($village->phase()->phaseNo()) {
                case VillagePhase::PHASE_DRAWING_CORE_MEMBER:
                    //ホストにメンバー募集が終了したメール送信
                    $end_phase_name = VillagePhase::PHASE_RECRUITMENT_OF_MEMBER_NAME;
                    foreach ($host_array as $host) {
                        $host = MemberCast::castHost($host);
                        Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    }
                    break;

                case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                    //ホスト、コア、ライズメンバーにメンバー抽選が終わったメール送信
                    $end_phase_name = VillagePhase::PHASE_DRAWING_CORE_MEMBER_NAME;
                    foreach ($host_array as $host) {
                        $host = MemberCast::castHost($host);
                        Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    }
                    foreach ($village_member_array as $village_member) {
                        $village_member = MemberCast::castVillageMember($village_member);
                        Mail::send(new EndPhaseEmail($village_member, $end_phase_name, $village, $url));
                    }
                    
                    //コアメンバーにコア意見募集が始まったメール送信
                    foreach ($core_member_array as $core_member) {
                        $core_member = MemberCast::castCoreMember($core_member);
                        Mail::send(new NextPhaseEmail($core_member, $village, $url));
                    }
                    break;

                case VillagePhase::PHASE_CATEGORIZE_OPINIONS:
                    //ホストにコア意見募集が終了したメール送信
                    $end_phase_name = VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER_NAME;
                    foreach ($host_array as $host) {
                        $host = MemberCast::castHost($host);
                        Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    }
                    break;
                
                case VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                    //ライズメンバーにコア意見募集が始まったメール送信
                    foreach ($rise_member_array as $rise_member) {
                        $rise_member = MemberCast::castRiseMember($rise_member);
                        Mail::send(new NextPhaseEmail($rise_member, $village, $url));
                    }
                    break;

                case VillagePhase::PHASE_EVALUATION:
                    //ホストにライズ意見募集が終了したメール送信
                    $end_phase_name = VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER_NAME;
                    foreach ($host_array as $host) {
                        $host = MemberCast::castHost($host);
                        Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    }
                    //コア、ライズメンバーに意見評価が始まったメール送信
                    foreach ($core_member_array as $core_member) {
                        $core_member = MemberCast::castCoreMember($core_member);
                        Mail::send(new NextPhaseEmail($core_member, $village, $url));
                    }
                    foreach ($rise_member_array as $rise_member) {
                        $rise_member = MemberCast::castRiseMember($rise_member);
                        Mail::send(new NextPhaseEmail($rise_member, $village, $url));
                    }
                    break;

                case VillagePhase::PHASE_DECIDING_POLICY:
                    //ホストに意見評価が終了したメール送信
                    $end_phase_name = VillagePhase::PHASE_EVALUATION_NAME;
                    foreach ($host_array as $host) {
                        $host = MemberCast::castHost($host);
                        Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    }
                    break;

                case VillagePhase::PHASE_SURVEYING_SATISFACTION:
                    //コア、ライズメンバーに満足度調査が始まったメール送信
                    foreach ($core_member_array as $core_member) {
                        $core_member = MemberCast::castCoreMember($core_member);
                        Mail::send(new NextPhaseEmail($core_member, $village, $url));
                    }
                    foreach ($rise_member_array as $rise_member) {
                        $rise_member = MemberCast::castRiseMember($rise_member);
                        Mail::send(new NextPhaseEmail($rise_member, $village, $url));
                    }
                    break;
            }
        }
        return true;
    }
}