<?php

namespace Modules\Support\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'support_tickets';

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'subject',
        'category',
        'message',
        'status',
        'admin_reply',
        'replied_by',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'open' => 'Aberto',
            'in_progress' => 'Em andamento',
            'answered' => 'Respondido',
            'closed' => 'Fechado',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'open' => 'blue',
            'in_progress' => 'amber',
            'answered' => 'emerald',
            'closed' => 'gray',
            default => 'gray',
        };
    }
}
