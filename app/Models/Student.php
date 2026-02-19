<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\Auditable;

class Student extends Model
{
    use Auditable, BelongsToUser, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'identifier',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_student', 'student_id', 'school_class_id')
            ->withTimestamps();
    }

    public function portfolioEntries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PortfolioEntry::class)->orderByDesc('occurred_at');
    }

    /**
     * Data payload for the QR Code.
     */
    public function getQrDataAttribute(): string
    {
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'uid' => substr(md5($this->id.$this->created_at.config('app.key')), 0, 8), // Simple hash for verification
        ]);
    }

    /**
     * Generate SVG QR Code.
     */
    public function getQrCodeSvgAttribute(): string
    {
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate($this->qr_data);
    }
}
