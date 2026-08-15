<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

class PendaftaranException extends RuntimeException
{
    protected array $errors = [];

    public function __construct(string $message = "", int $code = 400, array $errors = [], ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Mengambil array error per-field (contoh: ['tanggal_lahir' => 'Pesan error'])
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    // --- Named Constructors (Factory Methods) untuk Kerapihan Kode ---

    public static function sudahTerdaftar(): self
    {
        return new self('Anda sudah terdaftar dalam sistem pendaftaran.', 409); // 409 Conflict
    }

    public static function tanggalTidakValid(): self
    {
        return new self(
            'Kombinasi tanggal lahir tidak valid.',
            422, // 422 Unprocessable Entity
            ['tanggal_lahir' => 'Kombinasi tanggal, bulan, dan tahun lahir tidak valid.']
        );
    }

    public static function usiaTidakSesuai(string $jenjang, int $min, int $max, int $umurSaatIni): self
    {
        $pesan = "Untuk jenjang {$jenjang}, usia harus antara {$min} sampai {$max} tahun. Usia Anda saat ini {$umurSaatIni} tahun.";
        
        return new self(
            $pesan,
            422,
            ['tanggal_lahir' => $pesan]
        );
    }

    public static function jenjangTidakValid(): self
    {
        return new self(
            'Pilihan jenjang pendidikan tidak valid.',
            422,
            ['jenjang' => 'Silakan pilih jenjang pendidikan yang valid.']
        );
    }

    public static function gagalSimpan(): self
    {
        return new self('Gagal menyimpan data pendaftaran ke database.', 500);
    }
}