<?php

namespace Modules\Teacher\Livewire;

use Livewire\Component;
use App\Models\User;
use Modules\Marketplace\app\Models\MarketplaceItem;

class PublicProfile extends Component
{
    public $user;
    public $username;

    public function mount($username)
    {
        $this->username = $username;
        $this->user = User::where('username', $username)->firstOrFail();
    }

    public function buy($itemId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $item = MarketplaceItem::findOrFail($itemId);
        $buyer = auth()->user();

        if ($item->user_id === $buyer->id) {
            $this->dispatch('notify', type: 'error', message: 'Você não pode comprar seu próprio item.');
            return;
        }

        // 1. Process Logic (Mock Payment Success)
        \DB::transaction(function () use ($item, $buyer) {

            // Create Order
            $order = \Modules\Marketplace\app\Models\Order::create([
                'buyer_id' => $buyer->id,
                'total_amount' => $item->price,
                'status' => 'paid',
                'gateway_provider' => 'mock_wallet',
                'gateway_id' => 'tx_' . uniqid(),
            ]);

            $platformFee = $item->price * 0.20;
            $sellerEarnings = $item->price - $platformFee;

            // Create Order Item
            \Modules\Marketplace\app\Models\OrderItem::create([
                'order_id' => $order->id,
                'marketplace_item_id' => $item->id,
                'price_at_sale' => $item->price,
                'platform_fee' => $platformFee,
                'seller_earnings' => $sellerEarnings,
            ]);

            // Credit Seller Wallet
            $sellerWallet = \Modules\Finance\app\Models\Wallet::firstOrCreate(
                ['user_id' => $item->user_id],
                ['balance' => 0, 'withdrawable_balance' => 0]
            );

            $sellerWallet->increment('balance', $sellerEarnings);
            $sellerWallet->increment('withdrawable_balance', $sellerEarnings);

            // Record Transaction
            \Modules\Finance\app\Models\Transaction::create([
                'wallet_id' => $sellerWallet->id,
                'amount' => $sellerEarnings,
                'type' => 'sale',
                'description' => 'Venda: ' . $item->title,
                'metadata' => ['order_id' => $order->id, 'item_id' => $item->id],
            ]);

            // Deliver Content
            if ($item->lesson_plan_id && $item->lessonPlan) {
                $service = app(\Modules\Planning\Services\LessonPlanService::class);
                $service->cloneFrom($item->lessonPlan, $buyer, true);
            } elseif ($item->library_file_id && $item->libraryFile) {
                $sourceFile = $item->libraryFile;
                if ($sourceFile->path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sourceFile->path)) {
                    $extension = pathinfo($sourceFile->path, PATHINFO_EXTENSION);
                    $newPath = 'library/' . $buyer->id . '/' . uniqid('bought_', true) . '.' . $extension;

                    \Illuminate\Support\Facades\Storage::disk('public')->copy($sourceFile->path, $newPath);

                    \Modules\Library\app\Models\LibraryFile::create([
                        'user_id' => $buyer->id,
                        'name' => 'Cópia de ' . $sourceFile->name,
                        'path' => $newPath,
                        'size' => $sourceFile->size,
                        'mime_type' => $sourceFile->mime_type,
                        'description' => 'Comprado de ' . $item->user->name,
                    ]);
                }
            }

            // Increment sales count
            $item->increment('sales_count');
        });

        $this->dispatch('notify', type: 'success', message: 'Compra realizada! O material foi adicionado à sua biblioteca.');
    }

    public function render()
    {
        $items = MarketplaceItem::where('user_id', $this->user->id)
            ->where('status', 'published')
            ->with('reviews')
            ->withCount('reviews')
            ->latest()
            ->get();

        return view('teacher::livewire.public-profile', [
            'items' => $items
        ])->layout('layouts.guest-portfolio');
    }
}
