<?php

namespace Modules\ClassRecord\Services;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Support\Collection;
use Modules\Notebook\Services\GradeService;

/**
 * Flags students at risk: attendance < 75% or weighted average < 6.0 in a class.
 * All data scoped to the current user.
 */
class AtRiskService
{
    public function __construct(
        protected GradeService $gradeService
    ) {}

    /**
     * @return Collection<int, array{student: Student, school_class: SchoolClass, reasons: array<string>, grades_url: string}>
     */
    public function getAtRiskList(int $cycle = 1): Collection
    {
        $userId = auth()->id();
        if (! $userId) {
            return collect();
        }

        $students = Student::where('user_id', $userId)->with('schoolClasses.school')->get();
        $result = [];

        foreach ($students as $student) {
            foreach ($student->schoolClasses as $schoolClass) {
                $reasons = [];
                $attendancePct = $this->attendancePercentage($student->id, $schoolClass->id);
                if ($attendancePct !== null && $attendancePct < 75) {
                    $reasons[] = 'Frequência ' . round($attendancePct, 0) . '%';
                }
                $avg = $this->averageForStudentClass($student->id, $schoolClass->id, $cycle);
                if ($avg !== null && $avg < 6.0) {
                    $reasons[] = 'Média ' . number_format($avg, 1, ',', '');
                }
                if ($reasons === []) {
                    continue;
                }
                $result[] = [
                    'student' => $student,
                    'school_class' => $schoolClass,
                    'reasons' => $reasons,
                    'grades_url' => route('notebook.grades', $schoolClass),
                ];
            }
        }

        return collect($result);
    }

    /**
     * Attendance percentage for a student in a class (present/total). Null if no records.
     */
    protected function attendancePercentage(int $studentId, int $schoolClassId): ?float
    {
        $records = Attendance::withoutGlobalScope('user')
            ->where('student_id', $studentId)
            ->where('school_class_id', $schoolClassId)
            ->get();
        if ($records->isEmpty()) {
            return null;
        }
        $total = $records->count();
        $present = $records->where('status', true)->count();
        return $total > 0 ? ($present / $total) * 100 : null;
    }

    /**
     * Weighted average for a student in a class for the given cycle.
     */
    protected function averageForStudentClass(int $studentId, int $schoolClassId, int $cycle): ?float
    {
        $grades = Grade::withoutGlobalScope('user')
            ->where('student_id', $studentId)
            ->where('school_class_id', $schoolClassId)
            ->where('cycle', $cycle)
            ->get()
            ->keyBy('evaluation_type');
        $av1 = $grades->get('av1')?->score;
        $av2 = $grades->get('av2')?->score;
        $av3 = $grades->get('av3')?->score;
        return $this->gradeService->calculateWeightedAverage($av1, $av2, $av3);
    }
}
