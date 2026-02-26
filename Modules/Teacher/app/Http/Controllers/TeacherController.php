<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Teacher\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AiGenerationLog;
use App\Models\ClassDiary;
use Modules\Finance\Models\Wallet;
use Carbon\Carbon;

class TeacherController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Stats
        $activeClassesCount = $user->schoolClasses()->count();
        $lessonPlansCount = $user->lessonPlans()->count();
        $aiGenerationsCount = AiGenerationLog::where('user_id', $user->id)->count();

        // Wallet
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0, 'withdrawable_balance' => 0]
        );

        // Pending Diaries for today
        $today = Carbon::today();
        $dayOfWeek = now()->dayOfWeek;

        $todayClasses = $user->schoolClasses()
            ->whereHas('schedules', function ($q) use ($dayOfWeek) {
                $q->where('day_of_week', $dayOfWeek);
            })
            ->get();

        $pendingDiariesCount = 0;
        foreach ($todayClasses as $class) {
            $hasDiary = ClassDiary::where('school_class_id', $class->id)
                ->whereDate('scheduled_at', $today)
                ->where('is_finalized', true)
                ->exists();

            if (!$hasDiary) {
                $schedule = $class->schedules()
                    ->where('day_of_week', $dayOfWeek)
                    ->orderBy('start_time')
                    ->first();

                if ($schedule && $schedule->start_time <= now()->format('H:i:s')) {
                    $pendingDiariesCount++;
                }
            }
        }

        // Get the next class
        $nextClass = $user->schoolClasses()
            ->whereHas('schedules', function ($q) use ($dayOfWeek) {
                $q->where('day_of_week', $dayOfWeek)
                    ->where('start_time', '>', now()->format('H:i:s'));
            })
            ->with(['school', 'schedules' => function ($q) use ($dayOfWeek) {
                $q->where('day_of_week', $dayOfWeek)
                    ->where('start_time', '>', now()->format('H:i:s'))
                    ->orderBy('start_time');
            }])
            ->first();

        // Recent notifications
        $recentNotifications = $user->notifications()->latest()->take(5)->get();

        return view('teacher::dashboard', compact(
            'activeClassesCount',
            'lessonPlansCount',
            'aiGenerationsCount',
            'wallet',
            'pendingDiariesCount',
            'nextClass',
            'recentNotifications'
        ));
    }

    public function stats()
    {
        return view('teacher::stats');
    }
}
