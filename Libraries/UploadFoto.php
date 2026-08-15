<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;
use Exception;

class UploadFoto
{
    protected string $uploadPath = FCPATH . 'uploads/foto'; // Sesuaikan path direktori Anda

    public function store(?UploadedFile $file): ?string
    {
        if ($file === null || ! $file->isValid()) {
            return null;
        }

        // 1. Cek Permission (Apakah folder bisa ditulis?)
        if (! is_writable($this->uploadPath)) {
            throw new Exception('Gagal mengunggah foto: Sistem tidak memiliki izin akses (permission denied) ke folder penyimpanan.');
        }

        // 2. Cek Sisa Kapasitas Diska / Memori (misal: minimal butuh 10MB free space)
        $freeSpace = disk_free_space($this->uploadPath);
        if ($freeSpace !== false && $freeSpace < 10 * 1024 * 1024) { // < 10 MB
            throw new Exception('Gagal mengunggah foto: Kapasitas ruang penyimpanan server penuh.');
        }

        // 3. Cek Error Upload Bawaan PHP/CodeIgniter
        if ($file->hasMoved()) {
            throw new Exception('File foto sudah pernah dipindahkan.');
        }

        try {
            $newName = $file->getRandomName();
            $file->move($this->uploadPath, $newName);

            return $newName;
        } catch (\Throwable $e) {
            throw new Exception('Gagal menyimpan file foto ke server: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus file foto dari server (digunakan saat rollback transaction)
     */
    public function delete(?string $fileName): bool
    {
        if (empty($fileName)) {
            return false;
        }

        $filePath = $this->uploadPath . $fileName;

        if (file_exists($filePath)) {
            return @unlink($filePath);
        }

        return false;
    }

}