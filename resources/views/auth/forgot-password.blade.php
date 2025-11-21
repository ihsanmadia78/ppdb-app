@extends('layouts.guest')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Lupa Password</h4>
        <p class="text-muted mb-4">Lupa password? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link reset password.</p>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
