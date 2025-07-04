<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'additional_info',
        'accessed_at',
    ];

    protected function casts(): array
    {
        return [
            'additional_info' => 'array',
            'accessed_at' => 'datetime',
        ];
    }

    public $timestamps = false;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLabelAttribute()
    {
        return match ($this->action) {
            'view' => 'Lihat',
            'download' => 'Unduh',
            'upload' => 'Unggah',
            'update' => 'Update',
            'delete' => 'Hapus',
            default => $this->action,
        };
    }
}
