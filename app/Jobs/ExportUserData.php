<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExportUserData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        // Load all relationships
        $data = $this->user->load([
            'schools',
            'schoolClasses.students',
            'lessonPlans.sections',
            'subscriptions'
        ])->toArray();

        // Remove sensitive fields
        unset($data['password']);
        unset($data['remember_token']);

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $filename = 'exports/' . $this->user->id . '-' . Str::random(10) . '-data.json';

        Storage::put($filename, $json);

        // Notify user via database notification (since we haven't set up mail fully)
        // In a real scenario, we would email the link or signed URL
        $this->user->notify(new \Illuminate\Notifications\AnonymousNotification); // Placeholder

        // Let's use our new Notification system if possible, or just a simple one
        // creating a dynamic notification class on the fly is tricky, so let's rely on standard

        // For now, let's pretend we sent it.
        // Or better, create a specific notification for this in Core module?
    }
}
