<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'tanggal_diterima',
        'pengirim',
        'perihal',
        'file_path',
        'created_by',
        'ttd_pengirim_signature',
        'ttd_penerima_signature',
        'ttd_pengirim_nama',
        'ttd_penerima_nama',
    ];

    // ==========================================
    // RELASI
    // ==========================================

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==========================================
    // SCOPES
    // ==========================================

    public function scopeSearch(Builder $query, string $keyword)
    {
        return $query->where('no_surat', 'LIKE', "%{$keyword}%")
                     ->orWhere('pengirim', 'LIKE', "%{$keyword}%")
                     ->orWhere('perihal', 'LIKE', "%{$keyword}%");
    }

    public function scopeTanggal(Builder $query, ?string $start, ?string $end = null)
    {
        if ($start && $end) {
            return $query->whereBetween('tanggal_diterima', [$start, $end]);
        }
        if ($start) {
            return $query->whereDate('tanggal_diterima', $start);
        }
        return $query;
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    public function getTanggalDiterimaFormattedAttribute()
    {
        return $this->tanggal_diterima ? \Carbon\Carbon::parse($this->tanggal_diterima)->format('d/m/Y') : '-';
    }

    public function getTanggalSuratFormattedAttribute()
    {
        return $this->tanggal_surat ? \Carbon\Carbon::parse($this->tanggal_surat)->format('d/m/Y') : '-';
    }

    // ==========================================
    // BOOT (Event Listener)
    // ==========================================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($surat) {
            if (!$surat->tanggal_diterima) {
                $surat->tanggal_diterima = now();
            }
        });

        static::created(function ($surat) {
            $user = Auth::user();
            if ($user) {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'action' => 'create',
                    'model_type' => 'SuratMasuk',
                    'model_id' => $surat->id,
                    'new_data' => json_encode($surat->toArray()),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        });

        static::updated(function ($surat) {
            $user = Auth::user();
            if ($user) {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'action' => 'update',
                    'model_type' => 'SuratMasuk',
                    'model_id' => $surat->id,
                    'old_data' => json_encode($surat->getOriginal()),
                    'new_data' => json_encode($surat->toArray()),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        });

        static::deleted(function ($surat) {
            $user = Auth::user();
            if ($user) {
                LogAktivitas::create([
                    'user_id' => $user->id,
                    'action' => 'delete',
                    'model_type' => 'SuratMasuk',
                    'model_id' => $surat->id,
                    'old_data' => json_encode($surat->toArray()),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        });
    }
}