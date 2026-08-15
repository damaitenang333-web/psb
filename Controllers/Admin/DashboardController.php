<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Services\Santri\PendaftaranService;
use App\Services\Santri\ProfilService;
use App\Validation\SantriValidation;
use App\Exceptions\PendaftaranException;
use Config\Services;

class DashboardController extends BaseController
{
    protected $helpers = ['form', 'error', 'form_ui', 'tgl_indo', 'pendaftaran'];

    protected PendaftaranService $pendaftaranService;
    protected ProfilService $profilService;

    public function __construct()
    {
        $this->pendaftaranService = Services::pendaftaranService();
        $this->profilService      = Services::profilService();
    }

    public function index()
    {
        $allPendaftaran = $this->pendaftaranService->getAllPendaftaran();

        // Hitung statistik pendaftaran santri
        $totalSantri  = count($allPendaftaran);
        $totalPending = count(array_filter($allPendaftaran, fn($item) => $item['status_pendaftaran'] === PendaftaranModel::STATUS_VERIFIKASI));
        $totalLulus   = count(array_filter($allPendaftaran, fn($item) => $item['status_pendaftaran'] === PendaftaranModel::STATUS_LULUS));

        return view('admin/dashboard', [
            'title'        => 'Dashboard Admin PSB',
            'totalSantri'  => $totalSantri,
            'totalPending' => $totalPending,
            'totalLulus'   => $totalLulus,
        ]);
    }
}