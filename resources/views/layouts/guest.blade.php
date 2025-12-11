<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUMSER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tambah untuk ikon -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('{{ asset('images/sekolah/foto4.jpeg') }}') no-repeat center center fixed;
            background-size: cover;
            color: #212529;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 123, 255, 0.1); /* Overlay biru ringan biar gambar ga terlalu distracting */
            z-index: -1;
        }
        .hero {
            background: linear-gradient(45deg, #007bff, #0d6efd, #007bff);
            background-size: 200% 200%;
            animation: gradientAnimation 15s ease infinite;
            color: white;
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            z-index: 0;
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        /* Tambah siluet sapi subtle di hero, ubah warna biar biru */
        .hero::after {
            content: '';
            position: absolute;
            bottom: 20px;
            right: 50px;
            width: 150px;
            height: 100px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 60"><path d="M10 50 Q20 40 30 50 Q40 60 50 50 Q60 40 70 50 Q80 60 90 50" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="5"/><circle cx="20" cy="30" r="10" fill="rgba(255,255,255,0.2)"/><line x1="5" y1="50" x2="10" y2="55" stroke="rgba(255,255,255,0.2)" stroke-width="3"/><line x1="95" y1="50" x2="90" y2="55" stroke="rgba(255,255,255,0.2)" stroke-width="3"/></svg>') no-repeat;
            opacity: 0.3;
            z-index: 1;
        }
        .navbar {
            background: linear-gradient(to right, #007bff, #0d6efd);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand,
        .nav-link {
            color: white !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ced4da !important;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #007bff; /* Ubah ke biru */
            transition: transform 0.3s ease;
        }
        .feature-icon:hover {
            transform: scale(1.2);
        }
        .section-title {
            font-weight: 700;
            margin-bottom: 40px;
            color: #0d6efd; /* Biru gelap */
            position: relative;
        }
        .section-title::after {
            content: '';
            width: 60px;
            height: 4px;
            background: #007bff;
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            background: white;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.2); /* Shadow biru */
        }
        .btn-success {
            background: linear-gradient(to right, #007bff, #0d6efd);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-success:hover {
            background: linear-gradient(to right, #0d6efd, #007bff);
            transform: translateY(-2px);
        }
        footer {
            background: linear-gradient(to right, #0056b3, #007bff); /* Biru lebih gelap */
            color: #adb5bd;
            padding: 30px 0;
            position: relative;
        }
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, transparent, #0d6efd, transparent);
        }
        /* Tambah pola spot sapi di footer, ubah opacity */
        footer::after {
            content: '';
            position: absolute;
            top: 10px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: radial-gradient(circle, #000 10%, transparent 10%), radial-gradient(circle, #000 15%, transparent 15%);
            background-position: 0 0, 20px 20px;
            opacity: 0.1;
        }
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        .login-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-money-bill me-2"></i>JUMSER</a>
            <!-- Tambah ikon sapi di brand -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing') }}" wire:navigate>Beranda</a>
                    </li>
                    <li class="nav-item">
                        @auth
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        @else
                            <a class="nav-link" href="{{ route('login') }}" wire:navigate>Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {{ $slot }}
    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0">&copy; 2025 JUMSER. Semua Hak Dilindungi.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
