@component('mail::message')
# {{ $Name }}様

<p>【Tachi-No-Voice】をご利用いただき誠にありがとうございます。<br>ご参加ビレッジが<strong>{{ $next_phase_name }}</strong>フェーズに入りました。</p><br>
以下のボタンより、ご確認ください。

@component('mail::button', ['url' => $url])
参加しているビレッジへ移動する
@endcomponent

※こちらのメールは送信専用のメールアドレスより送信しております。恐れ入りますが、直接ご返信しないようお願いいたします。

@endcomponent

