<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends ResetPassword {
    protected function buildMailMessage($url) {
        return (new MailMessage)
            ->subject(Lang::get('Уведомление о сбросе пароля'))
            ->line(Lang::get('Вы получили это письмо, потому отправили запрос на сброс пароля для вашей учетной записи.'))
            ->action(Lang::get('Сбросить пароль'), $url)
            ->line(Lang::get('Срок действия ссылки для сброса пароля истечет через :count минут.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::get('Если вы не запрашивали сброс пароля, проигнорируйте это письмо.'));
    }
}
