<?php

if (! function_exists('format_error_summary')) {
    /**
     * Memformat daftar error validasi menjadi pesan ringkasan yang ramah pengguna.
     *
     * @param array  $errors       Array error dari $validation->getErrors() atau session('errors')
     * @param array  $customLabels Mapping label kustom ['field_key' => 'Label Manusia']
     * @param string $prefixText   Pesan awalan (misal: "Pendaftaran gagal" atau "Pembaruan profil gagal")
     * @return string
     */
    function format_error_summary(
        array $errors, 
        array $customLabels = [], 
        string $prefixText = 'Pendaftaran gagal'
    ): string {
        if (empty($errors)) {
            return '';
        }

        $defaultLabels = [
            'nik'           => 'NIK',
            'nama_lengkap'  => 'Nama Lengkap',
            'nisn'          => 'NISN',
            'kontak'        => 'Kontak',
            'tempat_lahir'  => 'Tempat Lahir', 
            'tgl'           => 'Tanggal Lahir',
            'bln'           => 'Tanggal Lahir',
            'thn'           => 'Tanggal Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'jenjang'       => 'Jenjang',
            'berkas_foto'   => 'Pas Foto'
        ];

        $labels = array_merge($defaultLabels, $customLabels);

        // Ambil nama label & bersihkan nilai dari karakter berbahaya (XSS)
        $fieldNames = array_unique(array_map(
            fn($key) => esc($labels[$key] ?? ucfirst(str_replace('_', ' ', $key))),
            array_keys($errors)
        ));

        // Format pembacaan daftar field agar alami (misal: "NIK, NISN, dan Kontak")
        $lastField = array_pop($fieldNames);
        if (! empty($fieldNames)) {
            $formattedFields = implode(', ', $fieldNames) . ' dan ' . $lastField;
        } else {
            $formattedFields = $lastField;
        }

        return esc($prefixText) . ', mohon perbaiki bagian <strong>' . $formattedFields . '</strong>.';
    }
}