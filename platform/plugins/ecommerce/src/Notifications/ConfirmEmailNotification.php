<?php

namespace Botble\Ecommerce\Notifications;

use EmailHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use URL;

class ConfirmEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        EmailHandler::setModule(ECOMMERCE_MODULE_SCREEN_NAME)
            ->setVariableValue('verify_link', URL::signedRoute('customer.confirm', ['user' => $notifiable->id]));
            $url=explode('/',$_SERVER['REQUEST_URI']);
            $lng = "it";
            if(strlen($url[1]) == 2){
                $lng = $url[1];
            }
            
         $template = $lng.'_confirm-email';
        $content = EmailHandler::prepareData(EmailHandler::getTemplateContent($template));

        return (new MailMessage())
            ->view(['html' => new HtmlString($content)])
            ->subject(EmailHandler::getTemplateSubject($template));
    }
}
