@extends('layouts.app')

@section('title', 'Kelola Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Kelola Pembayaran</h1>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pembayaran</h6>
        </div>
        <div class="card-body">
            @if($pembayaran->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Nominal</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $p)
                        <tr>
                            <td>{{ $p->pendaftar->no_pendaftaran }}</td>
                            <td>{{ $p->pendaftar->dataSiswa->nama ?? '-' }}</td>
                            <td>{{ $p->pendaftar->jurusan->nama ?? '-' }}</td>
                            <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                            <td>{{ strtoupper($p->metode_pembayaran ?? '-') }}</td>
                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge bg-secondary">Pending</span>
                                @elseif($p->status == 'paid')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($p->status == 'verified')
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($p->bukti_bayar)
                                    <a href="{{ asset('storage/' . $p->bukti_bayar) }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    @if($p->status == 'paid')
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifikasiModal{{ $p->id }}">
                                            <i class="fas fa-check"></i> Verifikasi
                                        </button>
                                    @endif
                                @else
                                    <span class="text-muted">Belum upload</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted text-center">Belum ada data pembayaran</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal Verifikasi -->
@foreach($pembayaran as $p)
@if($p->status == 'paid')
<div class="modal fade" id="verifikasiModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $p->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Pendaftar:</strong> {{ $p->pendaftar->dataSiswa->nama ?? $p->pendaftar->no_pendaftaran }}<br>
                        <strong>Nominal:</strong> Rp {{ number_format($p->nominal, 0, ',', '.') }}<br>
                        <strong>Metode:</strong> {{ strtoupper($p->metode_pembayaran) }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select name="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="verified">Valid - Terima Pembayaran</option>
                            <option value="rejected">Tolak - Bukti Tidak Valid</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Berikan catatan verifikasi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection