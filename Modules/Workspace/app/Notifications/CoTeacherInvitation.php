<?php

namespace Modules\Workspace\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CoTeacherInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $inviter;
    protected $schoolClass;

    public function __construct($inviter, $schoolClass)
    {
        $this->inviter = $inviter;
        $this->schoolClass = $schoolClass;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Convite para Co-Docência',
            'message' => "{$this->inviter->name} convidou você para colaborar na turma {$this->schoolClass->name}.",
            'icon' => 'chalkboard-teacher',
            'action_url' => route('workspace.show', $this->schoolClass->id),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Convite para Co-Docência - VertexOh!')
            ->greeting("Olá, {$notifiable->name}!")
            ->line("{$this->inviter->name} convidou você para ser professor colaborador na turma **{$this->schoolClass->name}**.")
            ->action('Acessar Turma', route('workspace.show', $this->schoolClass->id))
            ->line('Juntos vocês podem planejar aulas e acompanhar o desempenho dos alunos.');
    }
}
