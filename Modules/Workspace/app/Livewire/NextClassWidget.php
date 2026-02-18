<?php

namespace Modules\Workspace\Livewire;

use App\Models\SchoolClass;
use Carbon\Carbon;
use Livewire\Component;

class NextClassWidget extends Component
{
    public ?array $nextClass = null;

    public function mount(): void
    {
        $this->computeNext();
    }

    protected function computeNext(): void
    {
        $classes = SchoolClass::with(['schedules', 'school'])
            ->where('user_id', auth()->id())
            ->get();

        $now = Carbon::now();
        $best = null;
        $bestDt = null;

        foreach ($classes as $class) {
            foreach ($class->schedules as $schedule) {
                $next = $this->nextOccurrence($now, (int) $schedule->day_of_week, $schedule->start_time);
                if ($next && ($bestDt === null || $next < $bestDt)) {
                    $bestDt = $next;
                    $best = [
                        'class' => $class,
                        'schedule' => $schedule,
                        'at' => $next,
                    ];
                }
            }
        }

        $this->nextClass = $best;
    }

    /**
     * Get next occurrence of a weekday + time on or after $now.
     * day_of_week: 0 = Sunday, 1 = Monday, ... 6 = Saturday (PHP date('w')).
     */
    private function nextOccurrence(Carbon $now, int $dayOfWeek, string $startTime): ?Carbon
    {
        $daysAhead = ($dayOfWeek - $now->dayOfWeek + 7) % 7;
        $target = $now->copy()->startOfDay()->addDays($daysAhead)->setTimeFromTimeString($startTime);
        if ($target->lte($now)) {
            $target->addDays(7);
        }
        return $target;
    }

    public function render()
    {
        return view('workspace::livewire.next-class-widget');
    }
}
