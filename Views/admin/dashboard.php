<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <!-- Bootstrap 5 CSS & Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/icons-1.11.0/font/bootstrap-icons.css') ?>">
</head>
<body class="bg-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/admin/dashboard"><i class="bi bi-speedometer2 me-2"></i>Admin PSB</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline">Halo, <?= esc(auth()->user()->username ?? 'Admin') ?></span>
                <a href="/logout" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <!-- Header -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark">Dashboard Ringkasan</h3>
            <p class="text-muted">Selamat datang di Panel Kontrol Penerimaan Santri Baru.</p>
        </div>

        <!-- Kartu Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase small mb-1">Total Pendaftar</h6>
                            <h2 class="display-6 fw-bold mb-0"><?= $totalSantri ?></h2>
                        </div>
                        <i class="bi bi-people display-4 text-white-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-warning text-dark">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-dark-50 text-uppercase small mb-1">Perlu Verifikasi (Pending)</h6>
                            <h2 class="display-6 fw-bold mb-0"><?= $totalPending ?></h2>
                        </div>
                        <i class="bi bi-hourglass-split display-4 text-dark-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase small mb-1">Santri Diterima (Lulus)</h6>
                            <h2 class="display-6 fw-bold mb-0"><?= $totalLulus ?></h2>
                        </div>
                        <i class="bi bi-check-circle display-4 text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Navigasi Cepat -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-person-lines-fill text-success display-3 mb-3 d-block"></i>
                        <h5 class="fw-bold">Kelola Pendaftaran Santri</h5>
                        <p class="text-muted small">Lihat seluruh data pendaftar, verifikasi berkas, dan perbarui status kelulusan santri.</p>
                        <a href="<?= base_url('admin/pendaftaran') ?>" class="btn btn-success px-4">
                            <i class="bi bi-arrow-right-circle me-1"></i> Masuk Kelola Pendaftaran
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-newspaper text-primary display-3 mb-3 d-block"></i>
                        <h5 class="fw-bold">Kelola Artikel / Blog</h5>
                        <p class="text-muted small">Buat, perbarui, atau hapus artikel berita dan pengumuman untuk halaman utama website.</p>
                        <a href="<?= base_url('admin/blog/posts') ?>" class="btn btn-primary px-4">
                            <i class="bi bi-arrow-right-circle me-1"></i> Masuk Kelola Blog
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="<?= base_url('assets/bs530/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>