@extends('layouts.guest')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Verifikasi Email</h4>
        <p class="text-muted mb-4">
            Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email dengan mengklik link yang baru saja kami kirimkan? Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-muted">Log Out</button>
            </form>
        </div>
    </div>
</div>
@endsection
