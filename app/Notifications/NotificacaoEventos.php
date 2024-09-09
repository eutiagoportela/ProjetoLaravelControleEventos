<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Eventos;
use App\Models\Pessoas;

class NotificacaoEventos extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $eventoDia,$pessoaEmail;

    public function __construct(Eventos $evento,Pessoas $pessoa)
    {
        $this->eventoDia = $evento;
        $this->pessoaEmail = $pessoa;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting($this->pessoaEmail->nome)
                    ->subject('Seu evento foi confirmado para hoje!')
                    ->line('O evento que você se inscreveu esta confirmado para hoje as: '.$this->eventoDia->data)
                    ->line('No local: '.$this->eventoDia->local)
                    ->line('Seu Email Cadastrado: '.$this->pessoaEmail->email)
                    ->salutation('Agradecemos a sua presença!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
