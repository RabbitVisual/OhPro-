<?php

namespace App\Services;

use App\Models\ClassSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TeacherIncomeService
{
    /**
     * Hours per month estimate: weekly hours * (52/12) ≈ 4.33.
     */
    protected const WEEKS_PER_MONTH = 52 / 12;

    /**
     * Get estimated monthly income and breakdown by school.
     *
     * @return array{total: float, by_school: array<int, array{school_name: string, hours_per_month: float, amount: float}>}
     */
    public function getMonthlyEstimate(User $user): array
    {
        $schedules = ClassSchedule::with(['schoolClass.school'])
            ->whereHas('schoolClass', fn ($q) => $q->where('user_id', $user->id))
            ->get();

        $hoursPerWeekBySchool = [];
        foreach ($schedules as $schedule) {
            $schoolId = $schedule->schoolClass->school_id;
            $schoolName = $schedule->schoolClass->school->name ?? 'Escola';
            if (! isset($hoursPerWeekBySchool[$schoolId])) {
                $hoursPerWeekBySchool[$schoolId] = ['school_name' => $schoolName, 'hours' => 0.0];
            }
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $hoursPerWeekBySchool[$schoolId]['hours'] += $end->diffInMinutes($start) / 60;
        }

        $hourlyRate = $user->hourly_rate !== null ? (float) $user->hourly_rate : 0.0;
        $bySchool = [];
        $total = 0.0;
        foreach ($hoursPerWeekBySchool as $schoolId => $data) {
            $hoursPerMonth = $data['hours'] * self::WEEKS_PER_MONTH;
            $amount = round($hoursPerMonth * $hourlyRate, 2);
            $bySchool[] = [
                'school_id' => $schoolId,
                'school_name' => $data['school_name'],
                'hours_per_month' => round($hoursPerMonth, 1),
                'amount' => $amount,
            ];
            $total += $amount;
        }

        return [
            'total' => round($total, 2),
            'by_school' => $bySchool,
        ];
    }
}
