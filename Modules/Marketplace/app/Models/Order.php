<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Marketplace\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'buyer_id',
        'total_amount',
        'status',
        'gateway_provider',
        'gateway_id',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function buyer()
    {
        return $this->belongsTo(\App\Models\User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    // protected static function newFactory(): OrderFactory
    // {
    //     // return OrderFactory::new();
    // }
}
