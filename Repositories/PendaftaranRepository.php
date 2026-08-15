<?php

namespace App\Repositories;

use App\Models\PendaftaranModel;

class PendaftaranRepository
{
    protected PendaftaranModel $model;

    public function __construct(PendaftaranModel $model)
    {
        $this->model = $model;
    }

    public function getByUserId(int $userId): ?array
    {
        return $this->model->getByUserId($userId);
    }

    public function save(array $data): bool
    {
        return $this->model->save($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    public function getLastNoPendaftaran(string $tahun): ?string
    {
       
        $row = $this->model
            ->like('no_daftar', 'PSB-' . $tahun, 'after')
            ->orderBy('id', 'DESC')
            ->first();
        return $row['no_daftar'] ?? null;
    }

    /**
     * Mengambil semua data pendaftaran (opsional filter status)
     */
    public function getAll(?string $status = null): array
    {
        if ($status !== null && $status !== '') {
            $this->model->where('status_pendaftaran', $status);
        }
        return $this->model->orderBy('created_at', 'DESC')->findAll();
    }

    public function getPaginated(?string $status = null, int $perPage = 10): array
    {
        if ($status !== null && $status !== '') {
            $this->model->where('status_pendaftaran', $status);
        }

        return [

            'data' => $this->model->orderBy('created_at', 'DESC')->paginate($perPage, 'pendaftaran'),
            'pager' => $this->model->pager
        ]; 
    }

    /**
     * Cari pendaftaran berdasarkan ID Pendaftaran
     */
    public function getById(int $id): ?array
    {
        return $this->model->find($id);
    }

    public function updateStatus(int $pendaftaranId, string $statusBaru): bool
    {
        // Contoh implementasi menggunakan Query Builder / ORM standard
        return $this->model->update( $pendaftaranId, [
                                     'status_pendaftaran' => $statusBaru]);
    }
}
