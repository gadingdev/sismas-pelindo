@extends('layouts.app')

@section('title', 'Daftar Disposisi')

@section('content')

<!-- ========================================== -->
<!-- HEADER -->
<!-- ========================================== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">
            <i class="fas fa-paper-plane me-2" style="color: #003366;"></i> Daftar Disposisi
        </h1>
        <p class="text-muted small">Kelola semua disposisi surat</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('disposisi.track') }}" class="btn btn-outline-secondary">
            <i class="fas fa-search me-1"></i> Lacak Surat
        </a>
        <a href="{{ route('disposisi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Disposisi
        </a>
    </div>
</div>

<!-- ========================================== -->
<!-- FILTER -->
<!-- ========================================== -->
<div class="dashboard-table mb-4">
    <div class="p-3">
        <form method="GET" action="{{ route('disposisi.index') }}" class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('disposisi.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- TABEL DISPOSISI -->
<!-- ========================================== -->
<div class="dashboard-table">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3" style="width: 5%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">#</th>
                    <th class="py-3" style="width: 20%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Surat</th>
                    <th class="py-3" style="width: 18%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Dari</th>
                    <th class="py-3" style="width: 18%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Untuk</th>
                    <th class="py-3" style="width: 15%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Status</th>
                    <th class="py-3 text-center" style="width: 12%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Batas</th>
                    <th class="py-3 text-center pe-4" style="width: 12%; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6c757d; font-weight: 600;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($disposisis as $index => $disposisi)
                <tr>
                    <td class="ps-4 text-center text-muted fw-medium">{{ $disposisis->firstItem() + $index }}</td>
                    <td class="fw-semibold">
                        <span class="text-primary">{{ $disposisi->suratMasuk->no_surat ?? '-' }}</span>
                    </td>
                    <td>{{ $disposisi->dariUser->name ?? '-' }}</td>
                    <td>{{ $disposisi->untukUser->name ?? '-' }}</td>
                    <td>
                        @php
                            $statusMap = [
                                'pending' => ['bg' => 'bg-secondary', 'icon' => 'fa-clock', 'label' => 'Menunggu'],
                                'proses' => ['bg' => 'bg-warning', 'icon' => 'fa-spinner fa-spin', 'label' => 'Diproses'],
                                'selesai' => ['bg' => 'bg-success', 'icon' => 'fa-check-circle', 'label' => 'Selesai'],
                            ];
                            $status = $statusMap[$disposisi->status] ?? ['bg' => 'bg-secondary', 'icon' => 'fa-circle', 'label' => $disposisi->status];
                        @endphp
                        <span class="badge {{ $status['bg'] }} px-3 py-2 fw-medium">
                            <i class="fas {{ $status['icon'] }} me-1"></i>
                            {{ $status['label'] }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($disposisi->batas_waktu)
                            @php
                                $batas = \Carbon\Carbon::parse($disposisi->batas_waktu);
                                $isOverdue = $batas->isPast() && $disposisi->status != 'selesai';
                            @endphp
                            <span class="{{ $isOverdue ? 'text-danger fw-semibold' : 'text-muted' }}" style="font-size: 13px;">
                                {{ $batas->format('d/m/Y') }}
                                @if($isOverdue)
                                    <span class="badge bg-danger ms-1" style="font-size: 9px;">Lewat</span>
                                @endif
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center pe-4">
                        <a href="{{ route('disposisi.show', $disposisi->id) }}" 
                           class="btn btn-sm btn-outline-primary rounded-circle" 
                           title="Detail"
                           style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($disposisi->status != 'selesai' && auth()->user()->id == $disposisi->untuk_user_id)
                            <a href="{{ route('disposisi.edit', $disposisi->id) }}" 
                               class="btn btn-sm btn-outline-warning rounded-circle ms-1" 
                               title="Update Status"
                               style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-pen"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x d-block mb-3 text-muted opacity-50"></i>
                        <span class="fw-semibold">Belum ada disposisi</span>
                        <p class="small mb-0">Silakan buat disposisi baru</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top" style="background-color: #f8f9fa;">
        <div class="text-muted small">
            Menampilkan {{ $disposisis->firstItem() ?? 0 }} - {{ $disposisis->lastItem() ?? 0 }} dari {{ $disposisis->total() }} data
        </div>
        <div>
            {{ $disposisis->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<!-- SPACER -->
<div style="height: 40px;"></div>

@endsection