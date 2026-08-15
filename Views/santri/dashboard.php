<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title); ?></title>
    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/icons-1.11.0/font/bootstrap-icons.css') ?>">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><?= esc($nav); ?></a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline">Halo, <?= esc(auth()->user()->username ?? 'Santri') ?></span>
                <a href="/logout" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container my-4">

        <!-- Notifikasi Flashdata -->
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= esc(session()->getFlashdata('message')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- KONDISI 1: JIKA BELUM MENGISI FORMULIR -->
        <?php if (empty($pendaftaran)) : ?>
            <div class="card shadow-sm border-0 text-center p-5">
                <div class="card-body">
                    <i class="bi bi-file-earmark-text text-muted display-1 mb-3"></i>
                    <h3 class="fw-bold text-secondary">Anda Belum Mengisi Formulir</h3>
                    <p class="text-muted">Silakan lengkapi data pendaftaran Anda untuk dapat mengikuti proses seleksi penerimaan santri baru.</p>
                    <a href="/santri/formulir" class="btn btn-success btn-lg px-4 mt-2">
                        <i class="bi bi-pencil-square me-1"></i> Isi Formulir Pendaftaran
                    </a>
                </div>
            </div>

        <!-- KONDISI 2: JIKA SUDAH MENGISI FORMULIR -->
        <?php else : ?>

            <?php 
            // Panggil helper UI untuk mengambil warna, ikon, label, dan pesan
            $statusUi = render_status_pendaftaran($pendaftaran['status_pendaftaran']); 
            ?>

            <!-- Banner Status Pendaftaran -->
            <div class="alert <?= $statusUi['alert_color'] ?> shadow-sm d-flex align-items-center mb-4 p-4" role="alert">
                <i class="bi <?= $statusUi['icon'] ?> display-5 me-3"></i>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">
                        Status Pendaftaran: 
                        <span class="badge <?= $statusUi['badge_color'] ?> fs-6 ms-2">
                            <?= esc($statusUi['label']) ?>
                        </span>
                    </h5>
                    <p class="mb-0">
                        <?= $statusUi['message'] ?>
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Kolom Kiri: Ringkasan Kartu / Foto -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <!-- Foto Santri -->
                            <?php if (! empty($pendaftaran['berkas_foto'])) : ?>
                                <img src="/uploads/foto/<?= esc($pendaftaran['berkas_foto']) ?>" 
                                     alt="Pas Foto" 
                                     class="img-thumbnail rounded-3 mb-3" 
                                     style="max-height: 220px; width: 100%; object-fit: cover;">
                            <?php else : ?>
                                <div class="bg-light rounded p-4 mb-3 border">
                                    <i class="bi bi-person-bounding-box text-secondary display-3"></i>
                                    <p class="text-muted small mb-0 mt-2">Tidak ada foto</p>
                                </div>
                            <?php endif; ?>

                            <h5 class="fw-bold mb-1"><?= esc($pendaftaran['nama_lengkap']) ?></h5>
                            <p class="text-muted small mb-2">No. Pendaftaran:</p>
                            <span class="badge bg-dark fs-6 py-2 px-3"><?= esc($pendaftaran['no_daftar']) ?></span>
                            <div class="mt-3">
                                <a href="<?= base_url('santri/profile') ?>" class="btn btn-outline-dark btn-sm text-decoration-none">
                                    <i class="bi bi-gear me-1"></i> Update Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Detail Data Pendaftaran -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title fw-bold mb-0 text-success">
                                <i class="bi bi-person-lines-fill me-2"></i>Detail Data Pendaftaran
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0 align-middle">
                                <tbody>
                                    <tr>
                                        <th style="width: 35%;" class="ps-4">Nomor Pendaftaran</th>
                                        <td>: <strong><?= esc($pendaftaran['no_daftar']) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">NIK</th>
                                        <td>: <?= esc($pendaftaran['nik'] ?: '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Nama Lengkap</th>
                                        <td>: <?= esc($pendaftaran['nama_lengkap']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">NISN</th>
                                        <td>: <?= esc($pendaftaran['nisn'] ?: '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Kontak</th>
                                        <td>: <?= esc($pendaftaran['kontak'] ?: '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Tempat Lahir</th>
                                        <td>: <?= esc($pendaftaran['tempat_lahir'] ?: '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Tanggal Lahir</th>
                                        <td>: <?= esc(tgl_indo($pendaftaran['tanggal_lahir'] ?? null)) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Jenis Kelamin</th>
                                        <td>: <?= $pendaftaran['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Jenjang Tujuan</th>
                                        <td>: <span class="badge bg-primary"><?= esc($pendaftaran['jenjang']) ?></span></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-4">Tanggal Mendaftar</th>
                                        <td>: <?= esc(tgl_indo($pendaftaran['created_at'] ?? null, true)) ?> WIB</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-white text-muted small py-3">
                            <i class="bi bi-info-circle me-1"></i> Jika terdapat kesalahan data pada formulir di atas, silakan hubungi Panitia PSB.
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="<?= base_url('assets/bs530/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>