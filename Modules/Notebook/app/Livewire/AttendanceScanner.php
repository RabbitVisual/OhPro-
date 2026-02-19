<?php

namespace Modules\Notebook\Livewire;

use Livewire\Component;
use Modules\Notebook\Services\AttendanceService;
use App\Models\Student;

class AttendanceScanner extends Component
{
    public int $schoolClassId;
    public string $date;
    public bool $modalOpen = false;
    public ?string $lastScannedName = null;

    protected AttendanceService $attendanceService;

    public function boot(AttendanceService $attendanceService): void
    {
        $this->attendanceService = $attendanceService;
    }

    public function processScan($qrData)
    {
        try {
            $data = json_decode($qrData, true);

            if (!isset($data['id']) || !isset($data['uid'])) {
                throw new \Exception('Código inválido format.');
            }

            // Verify Hash
            $expectedUid = substr(md5($data['id'] . Student::find($data['id'])?->created_at . config('app.key')), 0, 8);
            if ($data['uid'] !== $expectedUid) {
                throw new \Exception('Código inválido ou adulterado.');
            }

            $student = Student::find($data['id']);
            if (!$student) {
                throw new \Exception('Aluno não encontrado.');
            }

            // Mark Present
            $this->attendanceService->setAttendance($student->id, $this->schoolClassId, $this->date, true);

            $this->lastScannedName = $student->name;
            $this->dispatch('scan-success', studentName: $student->name);
            $this->dispatch('refresh-attendance'); // Tell parent to refresh

        } catch (\Throwable $e) {
            $this->dispatch('scan-error', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('notebook::livewire.attendance-scanner');
    }
}
