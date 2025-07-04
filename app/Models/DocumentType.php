<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'allowed_extensions',
        'max_file_size_mb',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'allowed_extensions' => 'array',
            'is_active' => 'boolean',
            'max_file_size_mb' => 'integer',
        ];
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getAllowedExtensionsStringAttribute()
    {
        return implode(', ', $this->allowed_extensions ?? []);
    }
}
