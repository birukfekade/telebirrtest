<?php

namespace App\Services\Telebirr;

use Illuminate\Support\Facades\Http;

class TokenService
{
    public static function getToken(): ?string
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-APP-Key' => config('telebirr.fabric_app_id'),
        ])->withOptions(['verify' => false]) // Disable SSL cert check for testing ONLY
            ->post(config('telebirr.base_url') . '/payment/v1/token', [
                'appSecret' => config('telebirr.app_secret'),
            ]);

        return $response->json('token');
    }
}
