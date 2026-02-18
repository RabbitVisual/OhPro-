<?php

namespace Modules\Notebook\Services;

use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use InvalidArgumentException;

class GradeService
{
    /**
     * Default weights: Av1 = 3, Av2 = 3, Av3 = 4.
     * Can later be read from config or DB.
     */
    public function getWeights(): array
    {
        return [
            'av1' => 3,
            'av2' => 3,
            'av3' => 4,
        ];
    }

    /**
     * Weighted average: ((Av1*W1) + (Av2*W2) + (Av3*W3)) / (W1+W2+W3).
     * Only includes terms where score is not null. Rounded to one decimal (half up).
     */
    public function calculateWeightedAverage(?float $av1, ?float $av2, ?float $av3): ?float
    {
        $weights = $this->getWeights();
        $sum = 0.0;
        $totalWeight = 0;
        if ($av1 !== null && $av1 !== '') {
            $sum += (float) $av1 * $weights['av1'];
            $totalWeight += $weights['av1'];
        }
        if ($av2 !== null && $av2 !== '') {
            $sum += (float) $av2 * $weights['av2'];
            $totalWeight += $weights['av2'];
        }
        if ($av3 !== null && $av3 !== '') {
            $sum += (float) $av3 * $weights['av3'];
            $totalWeight += $weights['av3'];
        }
        if ($totalWeight === 0) {
            return null;
        }
        $value = $sum / $totalWeight;
        return round($value, 1, PHP_ROUND_HALF_UP);
    }

    public function save(int $studentId, int $schoolClassId, string $evaluationType, ?float $score, int $cycle): Grade
    {
        if ($score !== null) {
            $score = (float) $score;
            if ($score < 0.00 || $score > 10.00) {
                throw new InvalidArgumentException('A nota deve ser entre 0,00 e 10,00.');
            }
        }

        $schoolClass = SchoolClass::findOrFail($schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $student = Student::findOrFail($studentId);
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }

        return Grade::updateOrCreate(
            [
                'student_id' => $studentId,
                'school_class_id' => $schoolClassId,
                'evaluation_type' => $evaluationType,
                'cycle' => $cycle,
            ],
            ['score' => $score]
        );
    }

    public function getGradesForClass(SchoolClass $schoolClass, int $cycle): array
    {
        $students = $schoolClass->students()->orderBy('name')->get();
        $grades = Grade::withoutGlobalScope('user')
            ->where('school_class_id', $schoolClass->id)
            ->where('cycle', $cycle)
            ->get()
            ->keyBy(fn (Grade $g) => "{$g->student_id}_{$g->evaluation_type}");

        $result = [];
        foreach ($students as $student) {
            $av1 = $grades->get("{$student->id}_av1")?->score;
            $av2 = $grades->get("{$student->id}_av2")?->score;
            $av3 = $grades->get("{$student->id}_av3")?->score;
            $row = [
                'student' => $student,
                'av1' => $av1,
                'av2' => $av2,
                'av3' => $av3,
                'average' => $this->calculateWeightedAverage($av1, $av2, $av3),
            ];
            $result[] = $row;
        }
        return $result;
    }
}
