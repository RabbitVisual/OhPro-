<?php

namespace Modules\Workspace\Livewire;

use App\Services\TeacherIncomeService;
use Livewire\Component;

class FinancialOverviewWidget extends Component
{
    public function getDataProperty(): array
    {
        $user = auth()->user();
        $service = app(TeacherIncomeService::class);
        return $service->getMonthlyEstimate($user);
    }

    public function render()
    {
        return view('workspace::livewire.financial-overview-widget');
    }
}
