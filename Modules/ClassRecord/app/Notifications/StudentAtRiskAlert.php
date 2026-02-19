<?php

namespace Modules\ClassRecord\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StudentAtRiskAlert extends Notification implements ShouldQueue
{
    use Queueable;

    protected $student;
    protected $reason;

    public function __construct($student, $reason)
    {
        $this->student = $student;
        $this->reason = $reason;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail']; // Maybe just database to avoid spam
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'alert',
            'title' => 'Alerta de Risco: ' . $this->student->name,
            'message' => $this->reason,
            'icon' => 'exclamation-triangle',
            'action_url' => route('planning.student-report', $this->student->id), // Assuming route exists or will exist
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->fail() // Red button
            ->subject('Alerta Pedagógico - ' . $this->student->name)
            ->line("O aluno **{$this->student->name}** foi identificado em situação de risco.")
            ->line("Motivo: {$this->reason}")
            ->action('Ver Detalhes', route('planning.student-report', $this->student->id));
    }
}
