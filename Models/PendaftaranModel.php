<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'pendaftaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; 
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    public const STATUS_VERIFIKASI       = 'Pending';
    public const STATUS_BERKAS_DITERIMA  = 'Bercas_Diterima';
    public const STATUS_LULUS            = 'Lulus';
    public const STATUS_TIDAK_LULUS      = 'Tidak_Lulus';

    // Field yang boleh diisi melalui insert() atau update()
    protected $allowedFields    = [
        'user_id',
        'no_daftar',
        'nik',
        'nama_lengkap',
        'nisn',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'kontak',
        'jenjang',
        'status_pendaftaran',
        'berkas_foto',
    ];

    // Otomatis mengelola created_at dan updated_at
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Aturan Validasi
    protected $validationRules = [
        'user_id'            => 'required|numeric',
        'no_daftar'          => 'required|max_length[20]',
        'nama_lengkap'       => 'required|min_length[3]|max_length[255]',
        'nisn'               => 'permit_empty|exact_length[10]|numeric',
        'jenis_kelamin'      => 'required|in_list[L,P]',
        'jenjang'            => 'required|in_list[SMP,SMK]',
        'status_pendaftaran' => 'permit_empty|in_list[Pending,Bercas_Diterima,Lulus,Tidak_Lulus]',
        'berkas_foto'        => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'nama_lengkap' => [
            'required'   => 'Nama lengkap wajib diisi.',
            'min_length' => 'Nama lengkap minimal 3 karakter.',
        ],
        'jenis_kelamin' => [
            'in_list' => 'Pilih jenis kelamin yang valid (L/P).',
        ],
        'jenjang' => [
            'in_list' => 'Pilih jenjang pendidikan yang valid (SMP/SMK).',
        ],
        'nisn' => [
            'exact_length' => 'NISN harus berjumlah tepat 10 digit.',
            'numeric'      => 'NISN hanya boleh berupa angka.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Helper Method: Mengambil data pendaftaran berdasarkan User ID dari CI Shield
     */
    public function getByUserId(int $userId)
    {
        return $this->where('user_id', $userId)->first();
    }
}