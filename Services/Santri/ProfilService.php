<?php

namespace App\Services\Santri;
use App\Repositories\PendaftaranRepository;
use App\Libraries\UploadFoto;
use CodeIgniter\HTTP\Files\UploadedFile;

class ProfilService
{
    protected PendaftaranRepository $pendaftaranRepository;
    protected UploadFoto $uploadFoto;

    public function __construct
    (PendaftaranRepository $repository,
     UploadFoto $uploadFoto
    )
    {
        $this->pendaftaranRepository = $repository;
        $this->uploadFoto = $uploadFoto;
    }

    public function updateProfil(
        object $user,
        array $pendaftaran,
        array $postData,
        ?UploadedFile $fileFoto
    ): bool {

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {

            $namaFotoBaru = $this->uploadFoto->store(
                $fileFoto,
                $pendaftaran['berkas_foto'] ?? null
            );

            if ($namaFotoBaru && !empty($pendaftaran)) {
                $this->pendaftaranRepository->update(
                    $pendaftaran['id'],
                    ['berkas_foto' => $namaFotoBaru]
                );
            }
        }

        $users = auth()->getProvider();
        $isUserUpdated = false;

        if (!empty($postData['email']) && $postData['email'] !== $user->email) {
            $user->email = $postData['email'];
            $isUserUpdated = true;
        }

        if (!empty($postData['password'])) {
            $user->password = $postData['password'];
            $isUserUpdated = true;
        }

        if ($isUserUpdated) {
            $users->save($user);
        }

        return true;
    }
}