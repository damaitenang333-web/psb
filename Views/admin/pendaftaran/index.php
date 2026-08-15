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

        <!-- Header Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-people-fill text-success me-2"></i>Kelola Pendaftaran Santri</h4>
                <p class="text-muted small mb-0">Daftar seluruh calon santri baru yang telah mengisi formulir pendaftaran.</p>
            </div>
        </div>

        <!-- Flash Message Notifikasi -->
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= esc(session()->getFlashdata('message')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

            <!-- Filter Status (Bersih tanpa impor Model) -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <div class="d-flex align-items-center flex-wrap gap-2">
            <span class="fw-bold me-2 small text-muted"><i class="bi bi-filter me-1"></i>Filter Status:</span>
            
            <a href="<?= base_url('admin/pendaftaran') ?>" 
               class="btn btn-sm <?= empty($selectedFilter) ? 'btn-dark' : 'btn-outline-dark' ?>">
                Semua
            </a>

            <?php foreach ($listStatus as $st) : 
                $ui       = render_status_pendaftaran($st); 
                $isActive = ($selectedFilter === $st);
                $btnClass = $isActive ? $ui['badge_color'] : 'btn-outline-secondary';
            ?>
                <a href="<?= base_url('admin/pendaftaran?status=' . urlencode($st)) ?>" 
                   class="btn btn-sm <?= $btnClass ?>">
                    <?= esc($ui['label']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>




        <!-- Tabel Data Santri -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3" style="width: 5%;">#</th>
                                <th>No. Pendaftaran</th>
                                <th>Nama Lengkap</th>
                                <th>Jenjang</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 12%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pendaftaran)) : ?>
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-2 text-secondary"></i>
                                        Belum ada data pendaftaran<?= !empty($selectedFilter) ? ' dengan status ini' : '' ?>.
                                    </td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($pendaftaran as $index => $row) : ?>
                                    <?php $statusUi = render_status_pendaftaran($row['status_pendaftaran']); ?>
                                    <tr>
                                        <td class="ps-3 font-monospace"><?= $index + 1 ?></td>
                                        <td>
                                            <span class="badge bg-dark font-monospace"><?= esc($row['no_daftar']) ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= esc($row['nama_lengkap']) ?></div>
                                            <small class="text-muted">NIK: <?= esc($row['nik'] ?: '-') ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= esc($row['jenjang']) ?></span>
                                        </td>
                                        <td class="small">
                                            <?= esc(tgl_indo($row['created_at'] ?? null, true)) ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $statusUi['badge_color'] ?>">
                                                <?= esc($statusUi['label']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('admin/pendaftaran/detail/' . $row['id']) ?>" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="Detail & Ubah Status">
                                                <i class="bi bi-eye-fill me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php if (isset($pager) && $pendaftaran) : ?>
            <div class="mt-4 d-flex justify-content-center">
                <?= $pager->only(['status'])->links('pendaftaran', 'bootstrap_menarik') ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="<?= base_url('assets/bs530/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
