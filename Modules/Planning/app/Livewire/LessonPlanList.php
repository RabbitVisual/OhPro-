<?php

namespace Modules\Planning\Livewire;

use App\Models\LessonPlan;
use Livewire\Component;
use Livewire\WithPagination;

class LessonPlanList extends Component
{
    use WithPagination;

    public string $filterSchool = '';
    public string $filterClass = '';

    public function render()
    {
        $plans = LessonPlan::withCount('schoolClasses')
            ->when($this->filterSchool, function ($q) {
                $q->whereHas('schoolClasses', fn ($c) => $c->where('school_id', $this->filterSchool));
            })
            ->when($this->filterClass, function ($q) {
                $q->whereHas('schoolClasses', fn ($c) => $c->where('school_class_id', $this->filterClass));
            })
            ->orderByDesc('updated_at')
            ->paginate(10);

        $schools = auth()->user()->schools()->orderBy('name')->get();
        $classes = auth()->user()->schoolClasses()->with('school')->orderBy('name')->get();

        return view('planning::livewire.lesson-plan-list', [
            'plans' => $plans,
            'schools' => $schools,
            'classes' => $classes,
        ]);
    }
}
