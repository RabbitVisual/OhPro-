<?php

namespace Modules\Teacher\Livewire;

use Livewire\Component;
use Modules\Teacher\Services\TeacherStatsService;
use Illuminate\Support\Facades\Auth;

class AnnualReview extends Component
{
    public $stats;

    public function mount(TeacherStatsService $service)
    {
        $this->stats = $service->getAnnualStats(Auth::user());
    }

    public function render()
    {
        return view('teacher::livewire.annual-review');
    }
}
