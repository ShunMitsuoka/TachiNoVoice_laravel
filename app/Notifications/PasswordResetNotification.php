<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends ResetPassword
{
    use Queueable;

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $url = config('app.url')."/guest/password/resetPassword?token=".$this->token.'&email='.$notifiable->getEmailForPasswordReset();

        return (new MailMessage())
                    ->subject('【TACHI-NO-VOICE】パスワードリセット通知')
                    ->markdown('emails.password-reset', [
                        'reset_url' => $url
                    ]);
    }

}
