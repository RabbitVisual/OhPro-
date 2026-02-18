<?php

namespace Modules\Workspace\Livewire;

use App\Models\School;
use App\Models\SchoolClass;
use Livewire\Component;

class Dashboard extends Component
{
    public ?int $currentSchoolId = null;

    public function mount(): void
    {
        $schools = School::orderBy('name')->get();
        if ($schools->isEmpty()) {
            return;
        }
        $sessionId = session('workspace.current_school_id');
        if ($sessionId && $schools->contains('id', $sessionId)) {
            $this->currentSchoolId = $sessionId;
        } else {
            $this->currentSchoolId = $schools->first()->id;
            session(['workspace.current_school_id' => $this->currentSchoolId]);
        }
    }

    public function switchSchool(int $schoolId): void
    {
        $school = School::find($schoolId);
        if (!$school || $school->user_id !== auth()->id()) {
            return;
        }
        $this->currentSchoolId = $schoolId;
        session(['workspace.current_school_id' => $schoolId]);
    }

    public function getSchoolsProperty()
    {
        return School::orderBy('name')->get();
    }

    public function getCurrentSchoolProperty()
    {
        if (!$this->currentSchoolId) {
            return null;
        }
        return School::find($this->currentSchoolId);
    }

    public function getClassesProperty()
    {
        if (!$this->currentSchoolId) {
            return collect();
        }
        return SchoolClass::where('school_id', $this->currentSchoolId)->orderBy('name')->get();
    }

    public function getAtPlanLimitProperty(): bool
    {
        $user = auth()->user();
        if (! $user || $user->isPro()) {
            return false;
        }
        $maxClasses = $user->plan()->getLimit('max_classes');
        if ($maxClasses === null) {
            return false;
        }
        $totalClasses = SchoolClass::whereHas('school', fn ($q) => $q->where('user_id', $user->id))->count();
        return $totalClasses >= $maxClasses;
    }

    public function render()
    {
        return view('workspace::livewire.dashboard');
    }
}
