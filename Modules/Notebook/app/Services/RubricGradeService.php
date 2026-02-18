<?php

namespace Modules\Notebook\Services;

use App\Models\Rubric;
use App\Models\RubricAssessment;
use App\Models\RubricLevel;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class RubricGradeService
{
    public function __construct(
        protected GradeService $gradeService
    ) {}

    /**
     * Get rubric assessments for a student in a class and cycle (for modal prefill).
     *
     * @return Collection<int, RubricAssessment> keyed by rubric_id
     */
    public function getAssessmentsForStudentClassCycle(int $studentId, int $schoolClassId, int $cycle): Collection
    {
        $this->ensureTeacherOwnsStudentAndClass($studentId, $schoolClassId);

        return RubricAssessment::withoutGlobalScope('user')
            ->where('student_id', $studentId)
            ->where('school_class_id', $schoolClassId)
            ->where('cycle', $cycle)
            ->get()
            ->keyBy('rubric_id');
    }

    /**
     * Save rubric level selections, persist assessments, compute score (0-10) and save to Grade.
     * Score = average of level points (levels without points count as 0).
     *
     * @param  array<int, int>  $rubricLevelIds  rubric_id => rubric_level_id
     * @return float The score that was saved (0-10, one decimal)
     */
    public function saveFromRubricSelections(
        int $studentId,
        int $schoolClassId,
        int $cycle,
        string $evaluationType,
        array $rubricLevelIds
    ): float {
        if (! in_array($evaluationType, ['av1', 'av2', 'av3'], true)) {
            throw new InvalidArgumentException('Tipo de avaliação inválido.');
        }

        $this->ensureTeacherOwnsStudentAndClass($studentId, $schoolClassId);

        $userId = auth()->id();
        $pointsList = [];

        foreach ($rubricLevelIds as $rubricId => $levelId) {
            $rubricId = (int) $rubricId;
            $levelId = (int) $levelId;
            if ($rubricId <= 0 || $levelId <= 0) {
                continue;
            }

            $level = RubricLevel::where('id', $levelId)
                ->whereHas('rubric', fn ($q) => $q->where('user_id', $userId))
                ->first();

            if (! $level || $level->rubric_id != $rubricId) {
                continue;
            }

            RubricAssessment::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'school_class_id' => $schoolClassId,
                    'rubric_id' => $rubricId,
                    'cycle' => $cycle,
                ],
                ['rubric_level_id' => $levelId]
            );

            if ($level->points !== null) {
                $pointsList[] = (float) $level->points;
            }
        }

        if (empty($pointsList)) {
            throw new InvalidArgumentException('Selecione pelo menos um nível com valor de pontos para calcular a nota.');
        }

        $score = round(array_sum($pointsList) / count($pointsList), 1, PHP_ROUND_HALF_UP);
        $score = max(0, min(10, $score));

        $this->gradeService->save($studentId, $schoolClassId, $evaluationType, $score, $cycle);

        return $score;
    }

    protected function ensureTeacherOwnsStudentAndClass(int $studentId, int $schoolClassId): void
    {
        $schoolClass = SchoolClass::findOrFail($schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $student = Student::findOrFail($studentId);
        if ($student->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
