<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Admin\Models\SecurityLog;

class SecurityFeed extends Component
{
    use WithPagination;

    public function render()
    {
        return view('admin::livewire.security-feed', [
            'logs' => SecurityLog::with('user')->latest()->paginate(10)
        ]);
    }
}
