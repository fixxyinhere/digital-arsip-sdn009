<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'document_number',
        'description',
        'category_id',
        'document_type_id',
        'file_path',
        'file_name',
        'original_name',
        'mime_type',
        'file_size',
        'confidentiality_level',
        'document_date',
        'metadata',
        'uploaded_by',
        'updated_by',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'document_date' => 'date',
            'is_active' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function accessLogs()
    {
        return $this->hasMany(DocumentAccessLog::class);
    }

    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    public function getConfidentialityLabelAttribute()
    {
        return match ($this->confidentiality_level) {
            'public' => 'Publik',
            'internal' => 'Internal',
            'confidential' => 'Rahasia',
            'secret' => 'Sangat Rahasia',
            default => $this->confidentiality_level,
        };
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }
}
