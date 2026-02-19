<?php

namespace Modules\Marketplace\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Marketplace\Models\MarketplaceItem;
use Modules\Marketplace\Models\MarketplaceReview;

class ReviewForm extends Component
{
    public bool $modalOpen = false;

    public ?MarketplaceItem $item = null;

    public int $rating = 5;

    public string $comment = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    #[On('open-review-modal')]
    public function openModal(int $itemId)
    {
        $this->resetValidation();
        $this->item = MarketplaceItem::find($itemId);

        if (! $this->item) {
            return;
        }

        // Check if user bought this item
        // We need to check orders -> order_items
        $hasPurchased = \Modules\Marketplace\app\Models\Order::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->whereHas('items', function ($query) use ($itemId) {
                $query->where('marketplace_item_id', $itemId);
            })->exists();

        // Also allow review if user is the owner (for testing?) -> No, standard logic usually forbids.
        // But for development/testing, maybe? No, let's stick to "buyers only".
        // Wait, "Only users with a completed order...".

        if (! $hasPurchased) {
            $this->dispatch('notify', type: 'error', message: 'Você precisa comprar este item para avaliá-lo.');

            return;
        }

        // Check if already reviewed
        $review = MarketplaceReview::where('user_id', Auth::id())
            ->where('marketplace_item_id', $itemId)
            ->first();

        if ($review) {
            $this->rating = $review->rating;
            $this->comment = $review->comment;
        } else {
            $this->rating = 5;
            $this->comment = '';
        }

        $this->modalOpen = true;
    }

    public function save()
    {
        $this->validate();

        MarketplaceReview::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'marketplace_item_id' => $this->item->id,
            ],
            [
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]
        );

        $this->modalOpen = false;
        $this->dispatch('review-saved');
        $this->dispatch('notify', type: 'success', message: 'Avaliação enviada com sucesso!');
    }

    public function render()
    {
        return view('marketplace::livewire.review-form');
    }
}
