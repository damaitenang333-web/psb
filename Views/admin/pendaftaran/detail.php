<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Santri - <?= esc($santri['nama_lengkap']) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/icons-1.11.0/font/bootstrap-icons.css') ?>">
</head>
<body class="bg-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="/admin/dashboard">PANEL ADMIN PSB</a>
            <a href="/admin/pendaftaran" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
    </nav>

    <div class="container my-4">

        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Kolom Kiri: Pas Foto & Form Ubah Status -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4 text-center">
                    <div class="card-body">
                        <?php if (!empty($santri['berkas_foto'])) : ?>
                            <img src="/uploads/foto/<?= esc($santri['berkas_foto']) ?>" 
                                 alt="Pas Foto" 
                                 class="img-thumbnail rounded mb-3" 
                                 style="max-height: 250px; width: 100%; object-fit: cover;">
                        <?php else : ?>
                            <div class="bg-light rounded p-4 mb-3 border">
                                <i class="bi bi-person-bounding-box text-secondary display-3"></i>
                                <p class="text-muted small mb-0 mt-2">Tidak ada berkas foto</p>
                            </div>
                        <?php endif; ?>

                        <h5 class="fw-bold mb-0"><?= esc($santri['nama_lengkap']) ?></h5>
                        <p class="text-muted small"><?= esc($santri['no_daftar']) ?></p>
                    </div>
                </div>

                <?php use App\Models\PendaftaranModel; ?>

<!-- Form Ubah Status Pendaftaran -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2"></i>Ubah Status Pendaftaran</h6>
    </div>
    <div class="card-body">
        <form action="/admin/pendaftaran/update-status/<?= $santri['id'] ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="status_pendaftaran" class="form-label small text-muted">Pilih Status Baru:</label>
                    <select name="status_pendaftaran" id="status_pendaftaran" class="form-select">
                        <option value="<?= PendaftaranModel::STATUS_VERIFIKASI ?>" <?= $santri['status_pendaftaran'] === PendaftaranModel::STATUS_VERIFIKASI ? 'selected' : '' ?>>
                            Pending (Menunggu Verifikasi)
                        </option>
                        <option value="<?= PendaftaranModel::STATUS_BERKAS_DITERIMA ?>" <?= $santri['status_pendaftaran'] === PendaftaranModel::STATUS_BERKAS_DITERIMA ? 'selected' : '' ?>>
                            Berkas Diterima (Lolos Berkas)
                        </option>
                        <option value="<?= PendaftaranModel::STATUS_LULUS ?>" <?= $santri['status_pendaftaran'] === PendaftaranModel::STATUS_LULUS ? 'selected' : '' ?>>
                            Lulus Seleksi
                        </option>
                        <option value="<?= PendaftaranModel::STATUS_TIDAK_LULUS ?>" <?= $santri['status_pendaftaran'] === PendaftaranModel::STATUS_TIDAK_LULUS ? 'selected' : '' ?>>
                            Tidak Lulus
                        </option>
                    </select>
                </div>
                <div class="col-md-6 pt-md-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan Status
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
            </div>

            <!-- Kolom Kanan: Rincian Data Lengkap -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-card-heading me-2"></i>Rincian Data Pendaftar
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0 align-middle">
                            <tbody>
                                <tr>
                                    <th style="width: 35%;" class="ps-4">No. Pendaftaran</th>
                                    <td>: <strong><?= esc($santri['no_daftar']) ?></strong></td>
                                </tr>
                                <tr>
                                    <th class="ps-4">NIK</th>
                                    <td>: <?= esc($santri['nik']) ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4">Nama Lengkap</th>
                                    <td>: <?= esc($santri['nama_lengkap']) ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4">NISN</th>
                                    <td>: <?= esc($santri['nisn'] ?: '-') ?></td>
                                </tr>
                                <tr>
                                        <th class="ps-4">Tanggal Lahir</th>
                                        <td>: <?= date('d F Y', strtotime($santri['tanggal_lahir'])) ?></td>
                                    </tr>
                                <tr>
                                    <th class="ps-4">Jenis Kelamin</th>
                                    <td>: <?= $santri['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4">Kontak</th>
                                    <td>: <?= esc($santri['kontak'] ?: '-') ?></td>
                                </tr>
                                <tr>
                                    <th class="ps-4">Jenjang</th>
                                    <td>: <span class="badge bg-info text-dark"><?= esc($santri['jenjang']) ?></span></td>
                                </tr>
                                <tr>
                                    <th class="ps-4">Status Pendaftaran Saat Ini</th>
                                    <td>: 
                                        <?php $statusUI = render_status_pendaftaran($santri['status_pendaftaran']); ?>

                                        <span class="badge <?= esc($statusUI['badge_color']) ?>">
                                            <i class="bi <?= esc($statusUI['icon']) ?> me-1"></i>
                                            <?= esc($statusUI['label']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="ps-4">Tanggal Pendaftaran</th>
                                    <td>: <?= date('d F Y, H:i:s', strtotime($santri['created_at'])) ?> WIB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="<?= base_url('assets/bs530/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>