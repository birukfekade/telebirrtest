<?php

// File: app/Services/Telebirr/SignatureService.php

namespace App\Services\Telebirr;

class SignatureService
{
    public static function sign(array $params): string
    {
        unset($params['sign'], $params['sign_type']);
        ksort($params);

        $query = [];
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            $query[] = $key . '=' . $value;
        }

        $dataToSign = implode('&', $query);
        $privateKey = file_get_contents(config('telebirr.private_key_path'));
        openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }
}

