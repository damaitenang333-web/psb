<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Services\Santri\PendaftaranService;
use App\Services\Santri\ProfilService;
use App\Repositories\PendaftaranRepository;
use App\Models\PendaftaranModel;
use App\Libraries\UploadFoto;

class Services extends BaseService
{
    

    public static function pendaftaranService(
        bool $getShared = true
    )
    {

    if ($getShared) {
        return static::getSharedInstance('pendaftaranService');
    }

    return new PendaftaranService(
        static::pendaftaranRepository(),
        static::uploadFoto(),
        db_connect()
    );
    }

    public static function profilService(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('profilService');
        }

        return new ProfilService(
            static::pendaftaranRepository(),
            static::uploadFoto()
        );
    }

    public static function pendaftaranRepository(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('pendaftaranRepository');
        }

        return new PendaftaranRepository(
            static::pendaftaranModel()
        );
    }

    public static function uploadFoto(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('uploadFoto');
        }

        return new UploadFoto();
    }

    public static function pendaftaranModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('pendaftaranModel');
        }

        return new PendaftaranModel();
    }

    

}
