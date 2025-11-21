@extends('layouts.app')

@section('title', 'Riwayat Verifikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Riwayat Verifikasi</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Log Aktivitas Verifikasi</h6>
        </div>
        <div class="card-body">
            @if($riwayat->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Pendaftar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Verifikator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $r)
                        <tr>
                            <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $r->pendaftar->no_pendaftaran ?? '-' }}</td>
                            <td>{{ $r->pendaftar->dataSiswa->nama ?? '-' }}</td>
                            <td>
                                @if($r->status == 'SUBMIT')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif($r->status == 'VERIFIKASI_ADMIN')
                                    <span class="badge bg-info">Sedang Diverifikasi</span>
                                @elseif($r->status == 'MENUNGGU_PEMBAYARAN')
                                    <span class="badge bg-primary">Lulus Verifikasi</span>
                                @elseif($r->status == 'LULUS')
                                    <span class="badge bg-success">Lulus</span>
                                @elseif($r->status == 'TIDAK_LULUS')
                                    <span class="badge bg-danger">Tidak Lulus</span>
                                @else
                                    <span class="badge bg-secondary">{{ $r->status }}</span>
                                @endif
                            </td>
                            <td>{{ $r->keterangan }}</td>
                            <td>{{ $r->createdBy->name ?? 'System' }}</td>
                            <td>
                                <form method="POST" action="{{ route('verifikator.riwayat.delete', $r->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus riwayat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-muted text-center">Belum ada riwayat verifikasi</p>
            @endif
        </div>
    </div>
</div>
@endsection