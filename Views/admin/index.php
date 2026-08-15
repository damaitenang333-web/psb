<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Kelola Pendaftar PSB</title>
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/bootstrap.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/icons-1.11.0/font/bootstrap-icons.css') ?>">
</head>
<body class="bg-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-success" href="#">PANEL ADMIN PSB</a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline">Panitia: <?= esc(auth()->user()->username ?? 'Admin') ?></span>
                <a href="/logout" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 my-4">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-secondary">Daftar Pendaftar Santri Baru</h3>
            <span class="badge bg-secondary fs-6">Total: <?= count($pendaftar) ?> Santri</span>
        </div>

        <!-- Filter Data -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="get" action="/admin/dashboard" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Filter Jenjang</label>
                        <select name="jenjang" class="form-select">
                            <option value="">-- Semua Jenjang --</option>
                            <option value="SMP" <?= $jenjangFilter === 'SMP' ? 'selected' : '' ?>>SMP</option>
                            <option value="SMK" <?= $jenjangFilter === 'SMK' ? 'selected' : '' ?>>SMK</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold small">Filter Status</label>
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="Pending" <?= $statusFilter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Bercas_Diterima" <?= $statusFilter === 'Bercas_Diterima' ? 'selected' : '' ?>>Berkas Diterima</option>
                            <option value="Lulus" <?= $statusFilter === 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                            <option value="Tidak_Lulus" <?= $statusFilter === 'Tidak_Lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-filter me-1"></i> Terapkan Filter</button>
                        <a href="/admin/dashboard" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Data Pendaftar -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>No. Daftar</th>
                                <th>Nama Lengkap</th>
                                <th>NISN</th>
                                <th>JK</th>
                                <th>Jenjang</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pendaftar)) : ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">Belum ada data pendaftar.</td>
                                </tr>
                            <?php else : ?>
                                <?php $no = 1; foreach ($pendaftar as $row) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><span class="fw-bold text-dark"><?= esc($row['no_daftar']) ?></span></td>
                                        <td><?= esc($row['nama_lengkap']) ?></td>
                                        <td><?= esc($row['nisn'] ?: '-') ?></td>
                                        <td><?= esc($row['jenis_kelamin']) ?></td>
                                        <td><span class="badge bg-info text-dark"><?= esc($row['jenjang']) ?></span></td>
                                        <td>
                                            <?php 
                                            $st = $row['status_pendaftaran'];
                                            $badge = 'bg-secondary';
                                            if ($st === 'Pending') $badge = 'bg-warning text-dark';
                                            if ($st === 'Bercas_Diterima') $badge = 'bg-primary';
                                            if ($st === 'Lulus') $badge = 'bg-success';
                                            if ($st === 'Tidak_Lulus') $badge = 'bg-danger';
                                            ?>
                                            <span class="badge <?= $badge ?>"><?= str_replace('_', ' ', $st) ?></span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                        <td class="text-center">
                                            <a href="/admin/detail/<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Detail / Verifikasi
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

    </div>

    
    <script src="<?= base_url('assets/bs530/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>