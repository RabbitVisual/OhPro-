<?php

namespace Modules\ClassRecord\Livewire;

use Livewire\Component;
use Modules\ClassRecord\Services\AtRiskService;

class AtRiskWidget extends Component
{
    public function getAtRiskProperty(AtRiskService $service)
    {
        return $service->getAtRiskList(1);
    }

    public function render()
    {
        return view('classrecord::livewire.at-risk-widget');
    }
}
