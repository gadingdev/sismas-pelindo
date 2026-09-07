<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopeByUser(\Illuminate\Database\Eloquent\Builder $query, int $userId): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByModel(\Illuminate\Database\Eloquent\Builder $query, string $modelType, $modelId = null): \Illuminate\Database\Eloquent\Builder
    {
        $query->where('model_type', $modelType);
        if ($modelId) {
            $query->where('model_id', $modelId);
        }
        return $query;
    }

    public function scopeByAction(\Illuminate\Database\Eloquent\Builder $query, string $action): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('action', $action);
    }

    public function scopeToday(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereDate('created_at', today());
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    public function getActionLabelAttribute(): string
    {
        return [
            'create' => 'Membuat Data',
            'update' => 'Mengubah Data',
            'delete' => 'Menghapus Data',
            'view' => 'Melihat Data',
            'login' => 'Login',
            'logout' => 'Logout',
        ][$this->action] ?? $this->action;
    }

    public function getModelLabelAttribute(): string
    {
        $map = [
            'SuratMasuk' => 'Surat Masuk',
            'Disposisi' => 'Disposisi',
            'User' => 'User',
            'Kategori' => 'Kategori',
        ];
        return $map[$this->model_type] ?? $this->model_type;
    }

    // ==========================================
    // HELPER
    // ==========================================

    // Ambil data lama (decode JSON)
    public function getOldDataArrayAttribute(): ?array
    {
        return $this->old_data ? json_decode($this->old_data, true) : null;
    }

    // Ambil data baru (decode JSON)
    public function getNewDataArrayAttribute(): ?array
    {
        return $this->new_data ? json_decode($this->new_data, true) : null;
    }
}
