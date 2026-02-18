<?php

namespace Modules\Notebook\Livewire;

use App\Models\Rubric;
use App\Models\RubricAssessment;
use App\Models\SchoolClass;
use InvalidArgumentException;
use Livewire\Component;
use Modules\Notebook\Services\GradeService;
use Modules\Notebook\Services\RubricGradeService;

class GradeSpreadsheet extends Component
{
    public int $schoolClassId;

    public int $cycle = 1;

    public array $rows = [];

    public bool $rubricModalOpen = false;

    public int $rubricModalStudentId = 0;

    public string $rubricModalStudentName = '';

    public string $rubricModalEvaluationType = '';

    /** @var array<int, int> rubric_id => rubric_level_id */
    public array $rubricModalSelections = [];

    protected GradeService $gradeService;

    protected RubricGradeService $rubricGradeService;

    public function boot(GradeService $gradeService, RubricGradeService $rubricGradeService): void
    {
        $this->gradeService = $gradeService;
        $this->rubricGradeService = $rubricGradeService;
    }

    public function mount(int $schoolClassId, int $cycle = 1): void
    {
        $this->schoolClassId = $schoolClassId;
        $this->cycle = $cycle;
        $this->loadRows();
    }

    public function getRubricsProperty()
    {
        return Rubric::with('levels')->orderBy('sort_order')->get();
    }

    public function loadRows(): void
    {
        $schoolClass = SchoolClass::findOrFail($this->schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $this->rows = $this->gradeService->getGradesForClass($schoolClass, $this->cycle);

        $assessments = RubricAssessment::withoutGlobalScope('user')
            ->where('school_class_id', $this->schoolClassId)
            ->where('cycle', $this->cycle)
            ->get();
        $byStudent = $assessments->groupBy('student_id')->map(fn ($items) => $items->keyBy('rubric_id')->map(fn ($a) => $a->rubric_level_id)->all());

        foreach ($this->rows as $i => $row) {
            $sid = $row['student']->id;
            $this->rows[$i]['rubric_selections'] = $byStudent->get($sid, []);
        }
    }

    public function openRubricModal(int $studentId, string $studentName, string $evaluationType): void
    {
        $schoolClass = SchoolClass::findOrFail($this->schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $row = collect($this->rows)->firstWhere(fn ($r) => $r['student']->id === $studentId);
        $selections = $row['rubric_selections'] ?? [];
        $this->rubricModalStudentId = $studentId;
        $this->rubricModalStudentName = $studentName;
        $this->rubricModalEvaluationType = $evaluationType;
        $this->rubricModalSelections = $selections;
        $this->rubricModalOpen = true;
    }

    public function saveGradeFromRubric(): void
    {
        $this->dispatch('start-loading', message: 'Calculando nota pela rubrica...');
        try {
            $selections = array_filter($this->rubricModalSelections, fn ($v) => $v !== '' && $v !== null);
            $this->rubricGradeService->saveFromRubricSelections(
                $this->rubricModalStudentId,
                $this->schoolClassId,
                $this->cycle,
                $this->rubricModalEvaluationType,
                $selections
            );
            $this->loadRows();
            $this->rubricModalOpen = false;
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Nota calculada via rubrica com sucesso!', type: 'success');
        } catch (InvalidArgumentException $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Erro ao salvar.', type: 'error');
        }
    }

    public function saveGrade(int $studentId, string $evaluationType, $value): void
    {
        $this->dispatch('start-loading', message: 'Salvando nota...');
        $score = $value === '' || $value === null ? null : (float) $value;
        try {
            $this->gradeService->save($studentId, $this->schoolClassId, $evaluationType, $score, $this->cycle);
            $this->loadRows();
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Nota salva!', type: 'success');
        } catch (InvalidArgumentException $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Erro ao salvar.', type: 'error');
        }
    }

    /**
     * Sync a batch of pending grades (e.g. after coming back online).
     */
    public function syncGrades(array $pending): void
    {
        $synced = 0;
        foreach ($pending as $item) {
            $studentId = (int) ($item['student_id'] ?? 0);
            $type = (string) ($item['evaluation_type'] ?? '');
            $value = $item['value'] ?? null;
            if ($studentId && in_array($type, ['av1', 'av2', 'av3'], true)) {
                try {
                    $this->gradeService->save(
                        $studentId,
                        $this->schoolClassId,
                        $type,
                        $value === '' || $value === null ? null : (float) $value,
                        $this->cycle
                    );
                    $synced++;
                } catch (\Throwable) {
                    // continue with next
                }
            }
        }
        $this->loadRows();
        if ($synced > 0) {
            $this->dispatch('toast', message: "{$synced} nota(s) sincronizada(s).", type: 'success');
        }
    }

    public function updatedCycle($value): void
    {
        $this->cycle = (int) $value;
        $this->loadRows();
    }

    public function render()
    {
        return view('notebook::livewire.grade-spreadsheet');
    }
}
