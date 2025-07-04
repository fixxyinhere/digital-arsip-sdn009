<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'phone',
        'position',
        'address',
        'avatar',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(Document::class, 'uploaded_by');
    }

    public function updatedDocuments()
    {
        return $this->hasMany(Document::class, 'updated_by');
    }

    public function documentAccessLogs()
    {
        return $this->hasMany(DocumentAccessLog::class);
    }

    public function getPositionLabelAttribute()
    {
        return match ($this->position) {
            'operator' => 'Operator',
            'kepala_sekolah' => 'Kepala Sekolah',
            'guru' => 'Guru',
            default => $this->position,
        };
    }
}
