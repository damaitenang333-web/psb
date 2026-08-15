<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PendaftaranModel;
use App\Services\Santri\PendaftaranService;
use App\Services\Santri\ProfilService;
use App\Validation\SantriValidation;
use App\Exceptions\PendaftaranException;
use Config\Services;

class PendaftaranController extends BaseController
{
    protected $helpers = ['form', 'error', 'form_ui', 'tgl_indo', 'pendaftaran'];

    protected PendaftaranService $pendaftaranService;
    protected ProfilService $profilService;

    public function __construct()
    {
        $this->pendaftaranService = Services::pendaftaranService();
        $this->profilService      = Services::profilService();
    }

    /**
     * Menampilkan daftar pendaftar santri dengan fitur filter status
     */
    public function index()
    {
        $filterStatus    = $this->request->getGet('status');
        $pendaftaranData = $this->pendaftaranService->getPaginatedPendaftaran($filterStatus, 10);

        return view('admin/pendaftaran/index', [
            'title'          => 'Kelola Pendaftaran Santri',
            'pendaftaran'    => $pendaftaranData['data'],
            'pager'          => $pendaftaranData['pager'],
            'selectedFilter' => $filterStatus,
        // Kirim list status langsung dari controller
            'listStatus'     => [
            PendaftaranModel::STATUS_VERIFIKASI,
            PendaftaranModel::STATUS_BERKAS_DITERIMA,
            PendaftaranModel::STATUS_LULUS,
            PendaftaranModel::STATUS_TIDAK_LULUS,
        ],
    ]);
            
        
    }

    /**
     * Menampilkan detail pendaftaran santri
     */
    public function detail(int $id)
    {
        return view('admin/pendaftaran/detail', [
            'title'  => 'Detail Pendaftaran Santri',
            'santri' => $this->pendaftaranService->getPendaftaranById($id),
        ]);
    }

    /**
     * Memproses perubahan status pendaftaran santri
     */
    public function updateStatus(int $id)
    {
        $statusBaru = $this->request->getPost('status_pendaftaran');

        try {
            $this->pendaftaranService->ubahStatus($id, $statusBaru);
            return redirect()->back()->with('message', 'Status pendaftaran berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
