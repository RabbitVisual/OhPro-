<?php

namespace Modules\Workspace\Livewire;

use App\Models\ClassSchedule;
use Livewire\Component;

class WeeklyAgenda extends Component
{
    protected static array $dayLabels = [
        1 => 'Seg',
        2 => 'Ter',
        3 => 'Qua',
        4 => 'Qui',
        5 => 'Sex',
    ];

    public function getSchedulesByDayProperty(): array
    {
        $schedules = ClassSchedule::with(['schoolClass.school'])
            ->whereHas('schoolClass', fn ($q) => $q->where('user_id', auth()->id()))
            ->orderBy('start_time')
            ->get();

        $byDay = [];
        foreach (self::$dayLabels as $day => $label) {
            $byDay[$day] = $schedules->where('day_of_week', $day)->values()->all();
        }
        return $byDay;
    }

    public function attendanceUrl($schoolClass, ?string $date = null): string
    {
        $date = $date ?? now()->format('Y-m-d');
        return route('notebook.attendance', $schoolClass) . '?date=' . $date;
    }

    public function render()
    {
        return view('workspace::livewire.weekly-agenda');
    }
}
