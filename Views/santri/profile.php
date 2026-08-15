<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/bootstrap.min.css') ?>">
    <!-- Bootstrap Icons (CDN untuk Icon tambahan) -->
    <link rel="stylesheet" href="<?= base_url('assets/bs530/css/icons-1.11.0/font/bootstrap-icons.css') ?>">

    <style>
        .profile-avatar-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto;
        }
        .profile-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .avatar-upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background-color: #0d6efd;
            color: #fff;
            border-radius: 50%;
            padding: 8px 10px;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            transition: all 0.2s ease;
        }
        .avatar-upload-btn:hover {
            background-color: #0b5ed7;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-light py-4">

<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            
            <!-- Notifikasi Alert Flash Data -->
            <?php if (session()->getFlashdata('message')) : ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Card Utama -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-4 text-center border-0">
                    <h4 class="fw-bold mb-1"><i class="bi bi-person-gear me-2"></i>Pengaturan Akun</h4>
                    <p class="mb-0 opacity-75 fs-6">Perbarui foto profil, alamat email, dan kata sandi Anda</p>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="<?= base_url('santri/update-profile') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Section 1: Upload Foto Profil -->
                        <div class="text-center mb-4">
                            <div class="profile-avatar-wrapper mb-2">
                                <?php 
                                    $fotoSrc = (!empty($pendaftaran['berkas_foto']) && file_exists('uploads/foto/' . $pendaftaran['berkas_foto']))
                                        ? base_url('uploads/foto/' . $pendaftaran['berkas_foto'])
                                        : 'https://via.placeholder.com/150?text=No+Image';
                                ?>
                                <img src="<?= $fotoSrc ?>" id="previewFoto" class="profile-avatar" alt="Foto Profil">
                                <label for="berkas_foto" class="avatar-upload-btn" title="Ubah Foto">
                                    <i class="bi bi-camera-fill fs-6"></i>
                                </label>
                            </div>
                            <input type="file" name="berkas_foto" id="berkas_foto" class="d-none" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(this)">
                            <small class="text-muted d-block">Klik ikon kamera untuk mengganti foto (JPG/PNG, Max 2MB)</small>
                        </div>

                        <hr class="my-4 opacity-25">

                        <!-- Section 2: Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user->email) ?>" placeholder="nama@email.com" required>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <!-- Section 3: Ubah Password -->
                        <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-shield-lock me-2"></i>Ubah Password (Opsional)</h6>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="pass_confirm" class="form-label fw-semibold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                        <div class="form-text mt-2 text-muted">Biarkan kosong jika tidak ingin mengganti password saat ini.</div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="<?= base_url('santri/dashboard') ?>" class="btn btn-outline-secondary px-4 rounded-pill">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Script JS untuk Preview Foto & Auto Dismiss Alert -->
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewFoto').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>