<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class EncryptionService
{
    public function encrypt(string $content): string
    {
        return Crypt::encryptString($content);
    }

    public function decrypt(string $content): string
    {
        return Crypt::decryptString($content);
    }
}
