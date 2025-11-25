@extends('layouts.sidebar')

@section('title', 'Manajemen Jurusan')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">📚 Manajemen Jurusan</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus me-1"></i>Tambah Jurusan
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Jurusan</th>
                            <th>Kuota</th>
                            <th>Diterima</th>
                            <th>Sisa Kuota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurusan as $index => $j)
                        @php
                            $diterima = $j->pendaftar->where('status', 'LULUS')->count();
                            $sisaKuota = ($j->kuota ?? 30) - $diterima;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-primary">{{ $j->kode }}</span></td>
                            <td>{{ $j->nama }}</td>
                            <td>
                                <span class="badge bg-info">{{ $j->kuota ?? 30 }}</span>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $diterima }}</span>
                            </td>
                            <td>
                                @if($sisaKuota > 0)
                                    <span class="badge bg-warning text-dark">{{ $sisaKuota }}</span>
                                @else
                                    <span class="badge bg-danger">PENUH</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editJurusan({{ $j->id }}, '{{ $j->nama }}', '{{ $j->kode }}', {{ $j->kuota ?? 30 }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($j->pendaftar_count == 0)
                                <form method="POST" action="{{ route('admin.jurusan.delete', $j->id) }}" class="d-inline" onsubmit="return confirm('Yakin hapus jurusan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data jurusan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.jurusan.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan</label>
                        <input type="text" name="kode" class="form-control" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota Siswa</label>
                        <input type="number" name="kuota" class="form-control" value="30" min="1" max="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="editForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jurusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan</label>
                        <input type="text" name="kode" id="editKode" class="form-control" required maxlength="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kuota Siswa</label>
                        <input type="number" name="kuota" id="editKuota" class="form-control" min="1" max="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editJurusan(id, nama, kode, kuota) {
    document.getElementById('editForm').action = `{{ url('/admin/jurusan/update') }}/${id}`;
    document.getElementById('editNama').value = nama;
    document.getElementById('editKode').value = kode;
    document.getElementById('editKuota').value = kuota;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endsection
