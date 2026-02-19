<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'user_id',
        'lesson_plan_id',
        'library_file_id',
        'title',
        'description',
        'price',
        'status',
        'preview_path',
        'sales_count',
    ];

    protected $appends = ['average_rating'];

    public function reviews()
    {
        return $this->hasMany(MarketplaceReview::class, 'marketplace_item_id');
    }

    public function getAverageRatingAttribute()
    {
        // Cache this ideally, but for now simple agg
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    protected $casts = [
        'price' => 'decimal:2',
        'sales_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function lessonPlan()
    {
        return $this->belongsTo(\Modules\Planning\app\Models\LessonPlan::class);
    }

    public function libraryFile()
    {
        return $this->belongsTo(\Modules\Library\app\Models\LibraryFile::class);
    }
}
