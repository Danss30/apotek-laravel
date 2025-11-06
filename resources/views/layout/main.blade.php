<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Apotek</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 230px;
            height: 100vh;
            background-color: #1e2a38;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            color: #bfc9d2;
            padding: 10px 20px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        /* Content area */
        .content {
            margin-left: 230px;
            padding: 20px;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-custom {
            background-color: #1e2a38;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 10;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-custom .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .navbar-custom button {
            border: none;
        }

        /* Footer */
        footer {
            background-color: #1e2a38;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            left: 230px;
            right: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar-custom">
        <span class="navbar-brand"><i class="bi bi-capsule"></i> Aplikasi Apotek</span>
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ url('/') }}" class="d-flex align-items-center justify-content-center mb-3">
            <i class="bi bi-house-door fs-4 me-2"></i>
            <span class="fs-5 fw-bold">Home</span>
        </a>
        <hr class="border-light mx-3">
        <a href="{{ url('/perusahaan') }}"><i class="bi bi-building"></i> Perusahaan</a>
        <a href="{{ url('/customer') }}"><i class="bi bi-people"></i> Customer</a>
        <a href="{{ url('/produk') }}"><i class="bi bi-capsule"></i> Produk</a>
        <a href="{{ url('/penjualan') }}"><i class="bi bi-cash-stack"></i> Penjualan</a>
    </div>

    <!-- Content -->
    <div class="content mt-4">
        @yield('content')
    </div>
    <br><br>

    <!-- Footer -->
    <footer>
        <small>© {{ date('Y') }} Aplikasi Apotek - All Rights Reserved</small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
