<?php

use App\Models\PendaftaranModel;

if (! function_exists('render_status_pendaftaran')) {
    /**
     * Mengembalikan attribute UI (badge_color, alert_color, icon, label, deskripsi)
     * berdasarkan status pendaftaran.
     */
    function render_status_pendaftaran(?string $status): array
    {
        switch ($status) {
            case PendaftaranModel::STATUS_VERIFIKASI:
                return [
                    'label'       => 'Pending',
                    'badge_color' => 'bg-warning text-dark',
                    'alert_color' => 'alert-warning',
                    'icon'        => 'bi-hourglass-split',
                    'message'     => 'Berkas Anda telah diterima dan sedang menunggu verifikasi oleh Panitia PSB.',
                ];

            case PendaftaranModel::STATUS_BERKAS_DITERIMA:
                return [
                    'label'       => 'Berkas Diterima',
                    'badge_color' => 'bg-info text-dark',
                    'alert_color' => 'alert-info',
                    'icon'        => 'bi-file-earmark-check',
                    'message'     => 'Berkas Anda telah terverifikasi. Silakan melakukan pembayaran dan konfirmasi ke panitia pendaftaran.',
                ];

            case PendaftaranModel::STATUS_LULUS:
                return [
                    'label'       => 'Lulus',
                    'badge_color' => 'bg-success',
                    'alert_color' => 'alert-success',
                    'icon'        => 'bi-check-circle-fill',
                    'message'     => 'Selamat! Anda dinyatakan <strong>LULUS</strong> seleksi. Silakan lakukan pendaftaran ulang di sekretariat pesantren.',
                ];

            case PendaftaranModel::STATUS_TIDAK_LULUS:
                return [
                    'label'       => 'Tidak Lulus',
                    'badge_color' => 'bg-danger',
                    'alert_color' => 'alert-danger',
                    'icon'        => 'bi-x-circle-fill',
                    'message'     => 'Mohon maaf, Anda dinyatakan belum lulus seleksi pada periode ini. Tetap semangat!',
                ];

            default:
                return [
                    'label'       => 'Belum Mendaftar',
                    'badge_color' => 'bg-secondary',
                    'alert_color' => 'alert-secondary',
                    'icon'        => 'bi-clock-history',
                    'message'     => 'Status pendaftaran tidak ditemukan.',
                ];
        }
    }
}