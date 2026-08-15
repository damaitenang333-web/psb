<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran Santri Baru</title>
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/bootstrap.min.css') ?>">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulir Pendaftaran PSB</h4>
                </div>
                <div class="card-body">

                    <!-- Ringkasan Error Dinamis -->
                    <?php if (session()->has('errors') && is_array(session('errors'))) : ?>
                        <div class="alert alert-danger mb-4">
                            <?= format_error_summary(session('errors')) ?>
                        </div>
                    <?php endif; ?>

                    <form action="/santri/simpan" method="post" enctype="multipart/form-data" novalidate>
                        <?= csrf_field() ?>

                        <!-- NIK -->
                        <div class="mb-3">
                            <label class="form-label">NIK (16 Digit)</label>
                            <input type="text" name="nik" class="form-control <?= field_error('nik') ?>" maxlength="16" value="<?= old('nik') ?>">
                            <?= show_feedback('nik') ?>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control <?= field_error('nama_lengkap') ?>" value="<?= old('nama_lengkap') ?>">
                            <?= show_feedback('nama_lengkap') ?>
                        </div>

                        <!-- NISN -->
                        <div class="mb-3">
                            <label class="form-label">NISN (10 Digit)</label>
                            <input type="text" name="nisn" class="form-control <?= field_error('nisn') ?>" maxlength="10" value="<?= old('nisn') ?>">
                            <?= show_feedback('nisn') ?>
                        </div>

                        <!-- Kontak -->
                        <div class="mb-3">
                            <label class="form-label">Kontak (No. WhatsApp)</label>
                            <input type="text" name="kontak" class="form-control <?= field_error('kontak') ?>" maxlength="16" value="<?= old('kontak') ?>">
                            <?= show_feedback('kontak') ?>
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control <?= field_error('tempat_lahir') ?>" maxlength="100" value="<?= old('tempat_lahir') ?>">
                            <?= show_feedback('tempat_lahir') ?>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label class="form-label d-block">Tanggal Lahir</label>
                            <div class="row g-2">
                                <!-- Tanggal -->
                                <div class="col-4 col-md-3">
                                    <select name="tgl" class="form-select <?= field_error('tgl') ?>">
                                        <option value="">Tgl</option>
                                        <?php foreach (range(1, 31) as $i): $val = sprintf('%02d', $i); ?>
                                            <option value="<?= $val ?>" <?= old('tgl') == $val ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Bulan -->
                                <div class="col-4 col-md-5">
                                    <select name="bln" class="form-select <?= field_error('bln') ?>">
                                        <option value="">Bulan</option>
                                        <?php 
                                        $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                        foreach ($bulan as $k => $v): $val = sprintf('%02d', $k); 
                                        ?>
                                            <option value="<?= $val ?>" <?= old('bln') == $val ? 'selected' : '' ?>><?= $v ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Tahun -->
                                <div class="col-4 col-md-4">
                                    <select name="thn" class="form-select <?= field_error('thn') ?>">
                                        <option value="">Tahun</option>
                                        <?php foreach (range(date('Y'), date('Y') - 100) as $i): ?>
                                            <option value="<?= $i ?>" <?= old('thn') == $i ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Feedback Tanggal Lahir -->
                            <?php 
                            $errors    = session('errors') ?? \Config\Services::validation()->getErrors();
                            $dateError = $errors['tanggal_lahir'] ?? $errors['tgl'] ?? $errors['bln'] ?? $errors['thn'] ?? null;
                            if ($dateError) : 
                            ?>
                                <small class="text-danger d-block mt-1"><?= esc($dateError) ?></small>
                            <?php endif; ?>
                        </div>

                        <!-- Jenis Kelamin & Jenjang -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="jenis_kelamin" class="form-select <?= field_error('jenis_kelamin') ?>">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                <?= show_feedback('jenis_kelamin') ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenjang Tujuan</label>
                                <select name="jenjang" class="form-select <?= field_error('jenjang') ?>">
                                    <option value="">-- Pilih --</option>
                                    <option value="SMP" <?= old('jenjang') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                                    <option value="SMK" <?= old('jenjang') == 'SMK' ? 'selected' : '' ?>>SMK</option>
                                </select>
                                <?= show_feedback('jenjang') ?>
                            </div>
                        </div>

                        <!-- Berkas Foto -->
                        <div class="mb-3">
                            <label class="form-label">Pas Foto (Format: JPG/PNG, Maks. 2MB)</label>
                            <input type="file" name="berkas_foto" class="form-control <?= field_error('berkas_foto') ?>" accept="image/*">
                            <?= show_feedback('berkas_foto') ?>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Kirim Pendaftaran</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>