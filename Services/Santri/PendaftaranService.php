<?php

namespace App\Services\Santri;

use App\Exceptions\PendaftaranException;
use App\Libraries\UploadFoto;
use App\Models\PendaftaranModel;
use App\Repositories\PendaftaranRepository;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use DateTime;

class PendaftaranService
{
    protected PendaftaranRepository $pendaftaranRepository;
    protected UploadFoto $uploadFoto;
    protected ConnectionInterface $db; 

    public function __construct(
        PendaftaranRepository $repository,
        UploadFoto $uploadFoto, 
        ConnectionInterface $db
    ) {
        $this->pendaftaranRepository = $repository;
        $this->uploadFoto            = $uploadFoto;
        $this->db                    = $db;
    }

    public function getPendaftaranByUserId(int $userId): ?array
    {
        return $this->pendaftaranRepository->getByUserId($userId);
    }
    

    public function prosesSimpan(int $userId, array $postData, ?UploadedFile $fileFoto): bool
    {
        if ($this->getPendaftaranByUserId($userId)) {
            throw PendaftaranException::sudahTerdaftar();
        }

        return $this->pendaftarBaru($userId, $postData, $fileFoto);
    }

    public function pendaftarBaru(int $userId, array $postData, ?UploadedFile $fileFoto): bool
    {
        $tanggalLahir = $this->validasiTanggal(
            (int) ($postData['tgl'] ?? 0),
            (int) ($postData['bln'] ?? 0),
            (int) ($postData['thn'] ?? 0)
        );

        $jenjang = $postData['jenjang'] ?? '';
        $this->validasiUmur($tanggalLahir, $jenjang);

        $noDaftar = $this->generateNoPendaftaran();

        $namaFoto = null;
        if ($fileFoto !== null && $fileFoto->isValid() && ! $fileFoto->hasMoved()) { 
            $namaFoto = $this->uploadFoto->store($fileFoto);
        }

        $data = $this->susunDataPendaftaran($userId, $postData, $tanggalLahir, $jenjang, $namaFoto, $noDaftar);

        $this->db->transBegin();

        try {
            $simpan = $this->pendaftaranRepository->save($data);

            if (! $simpan || $this->db->transStatus() === false) {
                throw PendaftaranException::gagalSimpan();
            }

            $this->db->transCommit();
            return true;

        } catch (\Throwable $e) {
            $this->db->transRollback();

            if ($namaFoto !== null) {
                $this->uploadFoto->delete($namaFoto);
            }

            throw $e;
        }
    }

    private function validasiTanggal(int $tgl, int $bln, int $thn): string
    {
        if (! checkdate($bln, $tgl, $thn)) {
            throw PendaftaranException::tanggalTidakValid();
        }

        return sprintf('%04d-%02d-%02d', $thn, $bln, $tgl);
    }

    private function validasiUmur(string $tanggalLahir, string $jenjang): void
    {
        $lahir    = new DateTime($tanggalLahir);
        $sekarang = new DateTime();
        $umur     = $sekarang->diff($lahir)->y;

        $aturanUmur = [
            'SMP' => ['min' => 12, 'max' => 15],
            'SMK' => ['min' => 15, 'max' => 20],
        ];

        if (array_key_exists($jenjang, $aturanUmur)) {
            $min = $aturanUmur[$jenjang]['min'];
            $max = $aturanUmur[$jenjang]['max'];

            if ($umur < $min || $umur > $max) {
                // Fix: Hapus duplicate 'throw'
                throw PendaftaranException::usiaTidakSesuai($jenjang, $min, $max, $umur);
            }
        } else {
            throw PendaftaranException::jenjangTidakValid();
        }
    }

    private function generateNoPendaftaran(): string
    {
        $tahun = date('Y');

        $this->db->query(
            "INSERT IGNORE INTO pendaftaran_counters (tahun, last_number) VALUES (?, 0)",
            [$tahun]
        );

        $this->db->query(
            "UPDATE pendaftaran_counters SET last_number = LAST_INSERT_ID(last_number + 1) WHERE tahun = ?",
            [$tahun]
        );

        $nextNumber = (int) $this->db->query("SELECT LAST_INSERT_ID() as num")->getRow()->num;

        return sprintf('PSB-%s-%04d', $tahun, $nextNumber);
    }

    private function susunDataPendaftaran(
        int $userId,
        array $postData,
        string $tanggalLahir,
        string $jenjang,
        ?string $namaFoto,
        string $noDaftar
    ): array {
        return [
            'user_id'       => $userId,
            'no_daftar'     => $noDaftar,
            'nik'           => $postData['nik'] ?? null,
            'nama_lengkap'  => $postData['nama_lengkap'] ?? null,
            'nisn'          => $postData['nisn'] ?? null,
            'kontak'        => $postData['kontak'] ?? null,
            'jenis_kelamin' => $postData['jenis_kelamin'] ?? null,
            'tempat_lahir'  => $postData['tempat_lahir'] ?? null,
            'tanggal_lahir' => $tanggalLahir,
            'jenjang'       => $jenjang,
            'status_pendaftaran' => PendaftaranModel::STATUS_VERIFIKASI,
            'berkas_foto'   => $namaFoto,
        ];
    }

    public function getAllPendaftaran(?string $status = null): array
    {
        return $this->pendaftaranRepository->getAll($status);
    }

    public function getPaginatedPendaftaran(?string $status = null, int $perPage = 10): array
    {
        return $this->pendaftaranRepository->getPaginated($status, $perPage);
    }

    public function getPendaftaranById(int $id): array
    {
        $data = $this->pendaftaranRepository->getById($id);

        if (! $data) {
            throw new \RuntimeException('Data pendaftaran tidak ditemukan.');
        }

        return $data;
    }

    public function ubahStatus(int $pendaftaranId, string $statusBaru): bool
    {
        $allowedStatus = [
            PendaftaranModel::STATUS_VERIFIKASI,
            PendaftaranModel::STATUS_BERKAS_DITERIMA,
            PendaftaranModel::STATUS_LULUS,
            PendaftaranModel::STATUS_TIDAK_LULUS,
        ];

        if (! in_array($statusBaru, $allowedStatus, true)) {
            throw new \InvalidArgumentException(
                'Status pendaftaran tidak valid.'
            );
        }

        $this->getPendaftaranById($pendaftaranId);

        $updated = $this->pendaftaranRepository->updateStatus(
            $pendaftaranId,
            $statusBaru
        );

        if (! $updated) {
            throw PendaftaranException::gagalSimpan();
        }

        return true;
    }
}