<?php

if (! function_exists('tgl_indo')) {
    /**
     * Mengubah format tanggal MySQL (Y-m-d) menjadi format Indonesia (Contoh: 17 Mei 2008)
     */
    function tgl_indo(?string $datetime, bool $withTime = false): string
    {
        if (empty($datetime) || $datetime === '0000-00-00' || $datetime === '0000-00-00 00:00:00') {
            return '-';
        }

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $timestamp = strtotime($datetime);
        $tgl   = date('j', $timestamp);
        $bln   = (int) date('n', $timestamp);
        $thn   = date('Y', $timestamp);

        $result = $tgl . ' ' . $bulan[$bln] . ' ' . $thn;

        if ($withTime) {
            $jam = date('H:i', $timestamp);
            $result .= ', ' . $jam;
        }

        return $result;
    }
}