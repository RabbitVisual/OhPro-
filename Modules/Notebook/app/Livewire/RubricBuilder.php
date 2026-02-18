<?php

namespace Modules\Notebook\Livewire;

use App\Models\Rubric;
use App\Models\RubricLevel;
use Livewire\Component;

class RubricBuilder extends Component
{
    public ?int $editingId = null;

    public string $name = '';

    public string $description = '';

    public int $sort_order = 0;

    /** @var array<int, array{id?: int, name: string, description: string, points: string, sort_order: int}> */
    public array $levels = [];

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'levels.*.name' => 'required|string|max:80',
            'levels.*.description' => 'nullable|string',
            'levels.*.points' => 'nullable|numeric|min:0|max:10',
            'levels.*.sort_order' => 'integer|min:0',
        ];
    }

    public function openNew(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->description = '';
        $this->sort_order = (int) Rubric::max('sort_order') + 1;
        $this->levels = [['name' => '', 'description' => '', 'points' => '', 'sort_order' => 0]];
    }

    public function cancel(): void
    {
        $this->editingId = null;
        $this->reset(['name', 'description', 'sort_order', 'levels']);
        $this->levels = [];
    }

    public function edit(int $id): void
    {
        $rubric = Rubric::with('levels')->findOrFail($id);
        if ($rubric->user_id !== auth()->id()) {
            abort(403);
        }
        $this->editingId = $rubric->id;
        $this->name = $rubric->name;
        $this->description = $rubric->description ?? '';
        $this->sort_order = $rubric->sort_order;
        $this->levels = $rubric->levels->sortBy('sort_order')->map(fn ($l) => [
            'id' => $l->id,
            'name' => $l->name,
            'description' => $l->description ?? '',
            'points' => $l->points !== null ? (string) $l->points : '',
            'sort_order' => $l->sort_order,
        ])->values()->all();
        if (empty($this->levels)) {
            $this->levels = [['name' => '', 'description' => '', 'points' => '', 'sort_order' => 0]];
        }
    }

    public function addLevel(): void
    {
        $this->levels[] = ['name' => '', 'description' => '', 'points' => '', 'sort_order' => count($this->levels)];
    }

    public function removeLevel(int $index): void
    {
        array_splice($this->levels, $index, 1);
    }

    public function save(): void
    {
        $this->validate();
        $this->dispatch('start-loading', message: 'Salvando rubrica...');
        try {
            if ($this->editingId) {
                $rubric = Rubric::findOrFail($this->editingId);
                if ($rubric->user_id !== auth()->id()) {
                    abort(403);
                }
            } else {
                $rubric = new Rubric;
                $rubric->user_id = auth()->id();
            }
            $rubric->name = $this->name;
            $rubric->description = $this->description ?: null;
            $rubric->sort_order = $this->sort_order;
            $rubric->save();

            $existingIds = [];
            foreach ($this->levels as $i => $levelData) {
                $points = isset($levelData['points']) && $levelData['points'] !== '' ? (float) $levelData['points'] : null;
                if (isset($levelData['id']) && $levelData['id']) {
                    $level = RubricLevel::where('rubric_id', $rubric->id)->find($levelData['id']);
                    if ($level) {
                        $level->name = $levelData['name'];
                        $level->description = $levelData['description'] ?: null;
                        $level->points = $points;
                        $level->sort_order = $i;
                        $level->save();
                        $existingIds[] = $level->id;
                        continue;
                    }
                }
                $level = new RubricLevel;
                $level->rubric_id = $rubric->id;
                $level->name = $levelData['name'];
                $level->description = $levelData['description'] ?: null;
                $level->points = $points;
                $level->sort_order = $i;
                $level->save();
                $existingIds[] = $level->id;
            }
            RubricLevel::where('rubric_id', $rubric->id)->whereNotIn('id', $existingIds)->delete();

            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: 'Rubrica salva.', type: 'success');
            $this->editingId = null;
            $this->reset(['name', 'description', 'levels']);
        } catch (\Throwable $e) {
            $this->dispatch('stop-loading');
            $this->dispatch('toast', message: $e->getMessage() ?: 'Erro ao salvar.', type: 'error');
        }
    }

    public function deleteRubric(int $id): void
    {
        $rubric = Rubric::findOrFail($id);
        if ($rubric->user_id !== auth()->id()) {
            abort(403);
        }
        $this->dispatch('start-loading', message: 'Excluindo...');
        $rubric->delete();
        $this->dispatch('stop-loading');
        $this->dispatch('toast', message: 'Rubrica excluída.', type: 'success');
        if ($this->editingId === $id) {
            $this->openNew();
        }
    }

    public function getRubricsProperty()
    {
        return Rubric::withCount('levels')->orderBy('sort_order')->get();
    }

    public function render()
    {
        return view('notebook::livewire.rubric-builder');
    }
}
