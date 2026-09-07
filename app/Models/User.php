<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nip',
        'password',
        'role',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // HELPER
    // ==========================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function getRoleLabelAttribute(): string
    {
        return [
            'admin' => 'Admin',
            'staff' => 'Staff',
        ][$this->role] ?? $this->role;
    }

    // ==========================================
    // RELASI NOTIFIKASI (kalo pake)
    // ==========================================

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function unreadNotifikasis()
    {
        return $this->notifikasis()->where('is_read', false);
    }
}