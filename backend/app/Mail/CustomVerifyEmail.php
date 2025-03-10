<?php

namespace App\Mail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email') // تعديل العنوان
            ->greeting('Hello!') // تغيير التحية
            ->line('Please verify your email by clicking the button below.') // تعديل النص
            ->action('Verify Email', $verificationUrl) // زر التحقق
            ->line('If you did not create an account, no further action is required.') // تعديل الرسالة الختامية
            ->salutation('Thank you!'); // تعديل التوقيع
    }
}
