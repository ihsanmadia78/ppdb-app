@extends('layouts.guest')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Konfirmasi Password</h4>
        <p class="text-muted mb-4">Ini adalah area aman aplikasi. Silakan konfirmasi password Anda sebelum melanjutkan.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>
@endsection
