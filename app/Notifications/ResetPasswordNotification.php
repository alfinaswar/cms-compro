<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification using a custom view.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        $expire = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

        return (new MailMessage)
            ->subject('Permintaan Reset Kata Sandi - ' . config('app.name'))
            ->view('emails.reset-password', [
                'url' => $this->resetUrl($notifiable),
                'nama' => $notifiable->name ?? 'Pengguna',
                'email' => $notifiable->getEmailForPasswordReset(),
                'expire' => $expire,
            ]);
    }
}
