<?php

namespace App\Validation;

use App\Models\PendaftaranModel;

class SantriValidation
{

    public static function pendaftaran(): array
    {
        $allowedStatus = implode(',', [
            PendaftaranModel::STATUS_VERIFIKASI,
            PendaftaranModel::STATUS_BERKAS_DITERIMA,
            PendaftaranModel::STATUS_LULUS,
            PendaftaranModel::STATUS_TIDAK_LULUS,
        ]);

        return [
            'nik' => [
                'label' => 'NIK',
                'rules' => 'required|numeric|exact_length[16]|is_unique[pendaftaran.nik]',
                'errors' => [
                    'required'     => '{field} wajib diisi.',
                    'numeric'      => '{field} harus berupa angka.',
                    'exact_length' => '{field} harus persis 16 digit.',
                    'is_unique'    => '{field} sudah terdaftar.',
                ],
            ],

            'nisn' => [
                'label' => 'NISN',
                'rules' => 'required|numeric|exact_length[10]|is_unique[pendaftaran.nisn]',
                'errors' => [
                    'required'     => '{field} wajib diisi.',
                    'numeric'      => '{field} harus berupa angka.',
                    'exact_length' => '{field} harus persis 10 digit.',
                    'is_unique'    => '{field} sudah terdaftar.',
                ],
            ],

            'nama_lengkap' => [
                'label' => 'Nama Lengkap',
                'rules' => "required|min_length[3]|max_length[100]|regex_match[/^[a-zA-Z\s'.-]+$/]",
                'errors' => [
                    'required'    => '{field} wajib diisi.',
                    'min_length'  => '{field} minimal {param} karakter.',
                    'max_length'  => '{field} maksimal {param} karakter.',
                    'regex_match' => '{field} hanya boleh berisi huruf, spasi, titik, koma, atau tanda petik.',
                ],
            ],

            'jenis_kelamin' => [
                'label' => 'Gender',
                'rules' => 'required|in_list[L,P]',
                'errors' => [
                    'required' => '{field} wajib dipilih.',
                    'in_list'  => 'Pilihan {field} tidak valid.',
                ],
            ],

            'kontak' => [
                'label' => 'No. WhatsApp/HP',
                'rules' => 'required|min_length[10]|max_length[15]|numeric|is_unique[pendaftaran.kontak]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal {param} digit.',
                    'max_length' => '{field} maksimal {param} digit.',
                    'numeric'    => '{field} hanya boleh berisi angka.',
                    'is_unique'  => '{field} sudah terdaftar, gunakan nomor lain.',
                ],
            ],

            'tempat_lahir' => [
                'label' => 'Tempat Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ],
            ],

            'tgl' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[31]',
                'errors' => [
                    'required'              => '{field} wajib dipilih.',
                    'numeric'               => '{field} tidak valid.',
                    'greater_than_equal_to' => '{field} tidak valid.',
                    'less_than_equal_to'    => '{field} tidak valid.',
                ],
            ],

            'bln' => [
                'label' => 'Bulan Lahir',
                'rules' => 'required|numeric|greater_than_equal_to[1]|less_than_equal_to[12]',
                'errors' => [
                    'required'              => '{field} wajib dipilih.',
                    'numeric'               => '{field} tidak valid.',
                    'greater_than_equal_to' => '{field} tidak valid.',
                    'less_than_equal_to'    => '{field} tidak valid.',
                ],
            ],

            'thn' => [
                'label' => 'Tahun Lahir',
                'rules' => 'required|numeric|exact_length[4]|less_than_equal_to[' . date('Y') . ']',
                'errors' => [
                    'required'           => '{field} wajib dipilih.',
                    'numeric'            => '{field} tidak valid.',
                    'exact_length'       => '{field} harus 4 digit.',
                    'less_than_equal_to' => '{field} tidak boleh melebihi tahun saat ini.',
                ],
            ],

            'jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required|in_list[SMP,SMK]',
                'errors' => [
                    'required' => '{field} wajib dipilih.',
                    'in_list'  => 'Pilihan {field} tidak valid.',
                ],
            ],

            'berkas_foto' => [
                'label' => 'Pas Foto',
                'rules' => 'uploaded[berkas_foto]|is_image[berkas_foto]|mime_in[berkas_foto,image/png,image/jpeg,image/jpg]|max_size[berkas_foto,2048]',
                'errors' => [
                    'uploaded' => '{field} wajib diunggah.',
                    'is_image' => 'Berkas yang diunggah harus berupa gambar.',
                    'mime_in'  => 'Format {field} harus JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran {field} maksimal 2 MB.',
                ],
            ],
            'status_pendaftaran' => "permit_empty|in_list[{$allowedStatus}]",
        ];
    }

    public static function profile(int $userId): array
    {
        $rules = [

            'email' => [

                'rules' =>
                    "required|valid_email|is_unique[auth_identities.secret,user_id,{$userId}]",

                'errors' => [

                    'required'    => 'Email tidak boleh kosong.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah digunakan.',

                ]

            ],

            'berkas_foto' => [

                'rules' =>
                    'permit_empty|is_image[berkas_foto]|mime_in[berkas_foto,image/jpg,image/jpeg,image/png]|max_size[berkas_foto,2048]',

                'errors' => [

                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.',
                    'max_size' => 'Ukuran maksimal 2MB.',

                ]

            ],

        ];

        return $rules;
    }
}