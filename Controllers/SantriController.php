<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\Santri\PendaftaranService;
use App\Services\Santri\ProfilService;
use App\Validation\SantriValidation;
use App\Exceptions\PendaftaranException;
use Config\Services;

class SantriController extends BaseController
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
        $pendaftaran = $this->pendaftaranService->getPendaftaranByUserId(auth()->id());

        return view('santri/dashboard', [
            'title'       => 'Dashboard Santri - PSB Online',
            'nav'         => 'PSB Pesantren Attaufiqiyyah',
            'pendaftaran' => $pendaftaran,
        ]);
    }

    public function formulir()
    {
        if ($this->pendaftaranService->getPendaftaranByUserId(auth()->id())) {
            return redirect()->to('/santri/dashboard')->with('errors', 'Anda sudah mengisi formulir pendaftaran.');
        }

        return view('santri/formulir');
    }

    public function simpan()
    {
        $userId = auth()->id();

        // 1. Validasi Form Input
        if (! $this->validate(SantriValidation::pendaftaran())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postData = $this->request->getPost();
        $fileFoto = $this->request->getFile('berkas_foto');

        try {
            $this->pendaftaranService->prosesSimpan($userId, $postData, $fileFoto);

            return redirect()->to('santri/dashboard')->with('message', 'Pendaftaran berhasil dikirim');

        } catch (PendaftaranException $e) {
            // Jika user sudah terdaftar (HTTP Status Code 409)
            if ($e->getCode() === 409) {
                return redirect()->to('santri/dashboard')->with('errors', $e->getMessage());
            }

            // Jika terdapat validation errors per-field (seperti tanggal/umur)
            if (! empty($e->getErrors())) {
                return redirect()->back()->withInput()->with('errors', $e->getErrors());
            }

            // Fallback untuk error pendaftaran umum
            return redirect()->back()->withInput()->with('errors', ['general' => $e->getMessage()]);
        }
    }

    public function profile()
    {
        $userId = auth()->id();

        return view('santri/profile', [
            'title'       => 'Pengaturan Profil - PSB Online',
            'nav'         => 'PSB Pesantren Attaufiqiyyah',
            'user'        => auth()->user(),
            'pendaftaran' => $this->pendaftaranService->getPendaftaranByUserId($userId),
        ]);
    }

    public function updateProfile()
    {
        $user = auth()->user();
        $pendaftaran = $this->pendaftaranService->getPendaftaranByUserId($user->id);

        if (! $this->validate(SantriValidation::profile($user->id))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->profilService->updateProfil(
            $user,
            $pendaftaran ?? [],
            $this->request->getPost(),
            $this->request->getFile('berkas_foto')
        );

        return redirect()->to('/santri/profile')->with('message', 'Profil berhasil diperbarui!');
    }
}