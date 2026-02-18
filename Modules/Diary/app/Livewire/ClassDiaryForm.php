<?php

namespace Modules\Diary\Livewire;

use App\Models\ClassDiary;
use App\Models\SchoolClass;
use Livewire\Component;
use Modules\Diary\Services\ClassDiaryService;

class ClassDiaryForm extends Component
{
    public ClassDiary $diary;

    public function mount(ClassDiary $diary): void
    {
        if ($diary->user_id !== auth()->id()) {
            abort(403);
        }
        $this->diary = $diary;
    }

    public function finalize(string $signatureDataUrl): void
    {
        $this->dispatch('start-loading', message: 'Finalizando registro...');
        try {
            $service = app(ClassDiaryService::class);
            if (empty($signatureDataUrl) || !preg_match('#^data:image/#', $signatureDataUrl)) {
                $this->dispatch('stop-loading');
                $this->dispatch('toast', message: 'Assine antes de finalizar.', type: 'error');
                return;
            }
            $service->saveSignature($this->diary, $signatureDataUrl);
            $service->finalize($this->diary);
            $this->diary->refresh();
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Registro de aula finalizado.', type: 'success');
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage() ?: 'Erro ao finalizar.', type: 'error');
        }
    }

    public function render()
    {
        return view('diary::livewire.class-diary-form');
    }
}
