@extends('layouts.sidebar')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">👥 Kelola User</h1>
            <p class="text-muted mb-0">Manajemen pengguna sistem PPDB SMK BaktiNusantara 666</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tambah User -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">➕ Tambah User Baru</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="user@example.com" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="verifikator">Verifikator</option>
                            <option value="eksekutif">Eksekutif</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-plus me-1"></i>Tambah User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar User -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-gray-800">📋 Daftar User</h6>
        </div>
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%">No</th>
                                <th width="25%">Nama</th>
                                <th width="30%">Email</th>
                                <th width="15%">Role</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        @if($u->role == 'admin')
                                            <span class="badge bg-primary fs-6">Admin</span>
                                        @elseif($u->role == 'verifikator')
                                            <span class="badge bg-success fs-6">Verifikator</span>
                                        @elseif($u->role == 'eksekutif')
                                            <span class="badge bg-warning fs-6">Eksekutif</span>
                                        @else
                                            <span class="badge bg-secondary fs-6">{{ ucfirst($u->role) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @if($u->id != auth()->id())
                                                <form method="POST" action="{{ route('admin.users.delete', $u->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user {{ $u->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">Belum Ada User</h5>
                    <p class="text-muted">Tambahkan user pertama menggunakan form di atas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
