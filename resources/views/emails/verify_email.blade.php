@component('mail::message')
# ご登録ありがとうございます

この度はご登録いただき、ありがとうございます。<br>
ご登録を続けるには、以下のボタンをクリックしてください。

@component('mail::button', ['url' => $verify_url])
本登録
@endcomponent

※こちらのメールは送信専用のメールアドレスより送信しております。恐れ入りますが、直接ご返信しないようお願いいたします。

@endcomponent
