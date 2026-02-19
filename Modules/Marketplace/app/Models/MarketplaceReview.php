<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketplace_item_id',
        'user_id',
        'rating',
        'comment',
    ];

    public function item()
    {
        return $this->belongsTo(MarketplaceItem::class, 'marketplace_item_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
