<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class EncryptionHelper
{
    public static function encryptId($id)
    {
        return Crypt::encrypt($id);
    }

    public static function decryptId($encryptedId)
    {
        return Crypt::decrypt($encryptedId);
    }
}
