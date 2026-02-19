<?php

namespace Modules\Marketplace\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Library\app\Models\LibraryFile;
use Modules\Marketplace\app\Models\MarketplaceItem;
use Modules\Planning\app\Models\LessonPlan;

class PublishItem extends Component
{
    public bool $modalOpen = false;

    public ?string $itemType = null; // 'lesson_plan' or 'library_file'

    public ?int $itemId = null;

    public string $title = '';

    public string $description = '';

    public string $price = '';

    public bool $isPublished = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:5000',
        'price' => 'required|numeric|min:0',
    ];

    #[On('open-publish-modal')]
    public function openModal(string $type, int $id)
    {
        $this->resetValidation();
        $this->itemType = $type;
        $this->itemId = $id;

        $item = null;
        if ($type === 'lesson_plan') {
            $item = LessonPlan::find($id);
        } elseif ($type === 'library_file') {
            $item = LibraryFile::find($id);
        }

        if (! $item || $item->user_id !== Auth::id()) {
            return;
        }

        $this->title = $item->title ?? $item->name ?? '';

        // check if already published
        $marketplaceItem = MarketplaceItem::where('user_id', Auth::id())
            ->where(function ($q) use ($type, $id) {
                if ($type === 'lesson_plan') {
                    $q->where('lesson_plan_id', $id);
                }
                if ($type === 'library_file') {
                    $q->where('library_file_id', $id);
                }
            })->first();

        if ($marketplaceItem) {
            $this->title = $marketplaceItem->title;
            $this->description = $marketplaceItem->description;
            $this->price = $marketplaceItem->price;
            $this->isPublished = $marketplaceItem->status === 'published';
        } else {
            $this->description = ''; // Or some default
            $this->price = '';
            $this->isPublished = false;
        }

        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate();

        $marketplaceItem = MarketplaceItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_plan_id' => $this->itemType === 'lesson_plan' ? $this->itemId : null,
                'library_file_id' => $this->itemType === 'library_file' ? $this->itemId : null,
            ],
            [
                'title' => $this->title,
                'description' => $this->description,
                'price' => $this->price,
                'status' => 'published',
            ]
        );

        // Trigger PDF preview generation
        dispatch(new \App\Jobs\GeneratePreviewJob($marketplaceItem));

        $this->modalOpen = false;
        $this->dispatch('item-published');
        $this->dispatch('notify',
            type: 'success',
            message: 'Item publicado na loja com sucesso!'
        );
    }

    public function unpublish()
    {
        MarketplaceItem::where('user_id', Auth::id())
            ->where(function ($q) {
                if ($this->itemType === 'lesson_plan') {
                    $q->where('lesson_plan_id', $this->itemId);
                }
                if ($this->itemType === 'library_file') {
                    $q->where('library_file_id', $this->itemId);
                }
            })->update(['status' => 'draft']);

        $this->modalOpen = false;
        $this->dispatch('notify',
            type: 'info',
            message: 'Item removido da loja.'
        );
    }

    public function render()
    {
        return view('marketplace::livewire.publish-item');
    }
}
