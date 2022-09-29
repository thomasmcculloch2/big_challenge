<?php

namespace App\Notifications;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrescriptionAttached extends Notification
{
    use Queueable;

    private Submission $submission;
    private User $patient;
    private User $doctor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct (Submission $submission, User $patient, User $doctor)
    {
        $this->submission = $submission;
        $this->patient = $patient;
        $this->doctor = $doctor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Hola' . $this->patient->name . ',el doctor' . $this->doctor->name . 'te ha adjuntado una prescription a la submission' . $this->submission->title)
                    ->action('Ver ahora', url('/'))
                    ->line('Gracias por usar nuestra aplicacion!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
