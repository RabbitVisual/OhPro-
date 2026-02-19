<?php

namespace Modules\ClassRecord\Jobs;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\ClassRecord\Services\GoogleClassroomService;

class SyncGoogleRoster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $googleToken;
    protected $courseId;
    protected $targetClassId;
    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $googleToken, string $courseId, int $targetClassId, int $userId)
    {
        $this->googleToken = $googleToken;
        $this->courseId = $courseId;
        $this->targetClassId = $targetClassId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(GoogleClassroomService $service): void
    {
        try {
            $apiStudents = $service->listStudents($this->googleToken, $this->courseId);
            $class = SchoolClass::find($this->targetClassId);

            if (!$class) {
                return;
            }

            foreach ($apiStudents as $s) {
                $email = $s['profile']['emailAddress'] ?? null;
                $name = $s['profile']['name']['fullName'];
                $googleId = $s['userId'];

                if (!$email) continue;

                $student = Student::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'user_id' => $this->userId,
                        // 'google_id' => $googleId
                    ]
                );

                if (!$class->students()->where('student_id', $student->id)->exists()) {
                    $class->students()->attach($student->id);
                }
            }
        } catch (\Exception $e) {
            // Log error
            \Illuminate\Support\Facades\Log::error("SyncGoogleRoster failed: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
