<?php

namespace Modules\Notebook\Services;

use App\Models\Attendance;
use App\Models\SchoolClass;
use Carbon\Carbon;

class AttendanceService
{
    public function setAttendance(int $studentId, int $schoolClassId, string $date, bool $present): Attendance
    {
        $schoolClass = SchoolClass::findOrFail($schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        return Attendance::withoutGlobalScope('user')->updateOrCreate(
            [
                'student_id' => $studentId,
                'school_class_id' => $schoolClassId,
                'date' => $date,
            ],
            ['status' => $present]
        );
    }

    public function getAttendanceForClassAndDate(SchoolClass $schoolClass, string $date): array
    {
        $students = $schoolClass->students()->orderBy('name')->get();
        $attendances = Attendance::withoutGlobalScope('user')
            ->where('school_class_id', $schoolClass->id)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');

        return $students->map(function ($student) use ($attendances) {
            $att = $attendances->get($student->id);
            return [
                'student' => $student,
                'present' => $att ? $att->status : true,
            ];
        })->all();
    }
}
