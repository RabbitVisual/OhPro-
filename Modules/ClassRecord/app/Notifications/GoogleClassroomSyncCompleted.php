<?php

namespace Modules\ClassRecord\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class GoogleClassroomSyncCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $count;

    protected $className;

    public function __construct(int $count, string $className)
    {
        $this->count = $count;
        $this->className = $className;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Sincronização Concluída',
            'message' => "{$this->count} alunos importados do Google Classroom para a turma {$this->className}.",
            'icon' => 'google',
            'success' => true,
        ];
    }
}
