@component('mail::message')
# パスワード再設定のお知らせ

パスワード再設定を行うために、以下のボタンをクリックしてください。

@component('mail::button', ['url' => $reset_url])
パスワードリセット
@endcomponent

※こちらのメールは送信専用のメールアドレスより送信しております。恐れ入りますが、直接ご返信しないようお願いいたします。

@endcomponent
