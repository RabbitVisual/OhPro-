<?php

namespace Modules\Notebook\Livewire;

use App\Models\SchoolClass;
use Carbon\Carbon;
use Livewire\Component;
use Modules\Notebook\Services\AttendanceService;

class QuickAttendance extends Component
{
    public int $schoolClassId;

    public string $date;

    public array $rows = [];

    protected AttendanceService $attendanceService;

    public function boot(AttendanceService $attendanceService): void
    {
        $this->attendanceService = $attendanceService;
    }

    public function mount(int $schoolClassId, ?string $date = null): void
    {
        $this->schoolClassId = $schoolClassId;
        $this->date = $date ?? Carbon::today()->format('Y-m-d');
        $this->loadRows();
    }

    public function loadRows(): void
    {
        $schoolClass = SchoolClass::findOrFail($this->schoolClassId);
        if ($schoolClass->user_id !== auth()->id()) {
            abort(403);
        }
        $this->rows = $this->attendanceService->getAttendanceForClassAndDate($schoolClass, $this->date);
    }

    public function toggle(int $studentId, bool $present): void
    {
        $this->dispatch('start-loading', message: 'Salvando presença...');
        try {
            $this->attendanceService->setAttendance($studentId, $this->schoolClassId, $this->date, $present);
            $this->loadRows();
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Presença atualizada.', type: 'success');
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Erro ao salvar.', type: 'error');
        }
    }

    public function render()
    {
        return view('notebook::livewire.quick-attendance');
    }
}
