<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .dark-mode {
            background-color: #1e1e2f;
            color: #eaeaea;
        }
        .sidebar {
            height: 100vh;
            background: #0d6efd;
            color: white;
            padding-top: 20px;
            position: fixed;
            width: 230px;
        }
        .sidebar h4 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px 10px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        .content {
            margin-left: 250px;
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .dark-mode .card {
            background-color: #2b2b3c;
            color: #eaeaea;
        }
        .toggle-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background: #ffc107;
            color: black;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .dark-mode .toggle-btn {
            background: #198754;
            color: white;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>🧑‍💼 PPDB Admin</h4>
    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('admin.pendaftar') }}">📋 Data Pendaftar</a>
    <a href="{{ route('admin.jurusan') }}">📚 Jurusan</a> {{-- ✅ penting --}}
    <a href="{{ route('logout') }}">🚪 Logout</a>
</div>

<div class="content">
    <button class="toggle-btn" id="toggleMode">🌙 Dark Mode</button>

    <h2 class="mb-4">📊 Dashboard Statistik</h2>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-center text-white bg-primary mb-3">
                <div class="card-body">
                    <h4>{{ $total }}</h4>
                    <p>Total Pendaftar</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center text-white bg-success mb-3">
                <div class="card-body">
                    <h4>{{ $diterima }}</h4>
                    <p>Diterima</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center text-white bg-danger mb-3">
                <div class="card-body">
                    <h4>{{ $ditolak }}</h4>
                    <p>Ditolak</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center text-white bg-warning mb-3">
                <div class="card-body">
                    <h4>{{ $menunggu }}</h4>
                    <p>Menunggu</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Statistik --}}
    <div class="card mt-4 p-4">
        <h5>📈 Grafik Pendaftar per Jurusan</h5>
        <canvas id="chartJurusan" height="120"></canvas>
    </div>

    {{-- Tabel Pendaftar Terbaru --}}
    <div class="card mt-4 p-4">
        <h5>🧾 5 Pendaftar Terbaru</h5>
        <table class="table table-bordered mt-3">
            <thead class="table-secondary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($terbaru as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->dataSiswa->nama ?? '-' }}</td>
                        <td>{{ $p->jurusan->nama ?? '-' }}</td>
                        <td>
                            @php $st = $p->status; @endphp
                            <span class="badge 
                                @if($st == 'SUBMIT') bg-warning 
                                @elseif($st == 'DITERIMA' || $st == 'LULUS') bg-success 
                                @elseif($st == 'DITOLAK' || $st == 'TIDAK_LULUS') bg-danger 
                                @else bg-secondary @endif">
                                {{ $st == 'DITERIMA' || $st == 'LULUS' ? 'Diterima' : ($st == 'DITOLAK' || $st == 'TIDAK_LULUS' ? 'Ditolak' : $st) }}
                            </span>
                        </td>
                        <td>{{ $p->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer class="mt-5 text-center text-muted">
        &copy; {{ date('Y') }} PPDB Sekolah | Dashboard Admin
    </footer>
</div>

<script>
    // Data untuk Chart.js
    const labels = @json($labels);
    const data = @json($data);

    new Chart(document.getElementById('chartJurusan'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: data,
                backgroundColor: [
                    '#0d6efd','#198754','#dc3545','#ffc107','#6610f2'
                ]
            }]
        }
    });

    // Toggle Dark Mode
    document.getElementById('toggleMode').addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
        this.textContent = document.body.classList.contains('dark-mode') 
            ? '☀️ Light Mode' : '🌙 Dark Mode';
    });
</script>

</body>
</html>
