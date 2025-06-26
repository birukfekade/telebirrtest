<?php

namespace App\Services\Telebirr;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http;

class OrderService
{
    public static function createOrder($title, $amount)
    {
        $token = TokenService::getToken();
        $timestamp = time();
        $nonce = Str::random(32);
        $merchOrderId = $timestamp;

        $biz = [
            "notify_url" => config('telebirr.notify_url'),
            "appid" => config('telebirr.merchant_app_id'),
            "merch_code" => config('telebirr.merchant_code'),
            "merch_order_id" => $merchOrderId,
            "trade_type" => "WebCheckout",
            "title" => "goods",
            "total_amount" => $amount,
            "trans_currency" => "ETB",
            "timeout_express" => "120m",
            "business_type" => "TransferToOtherOrg",
            "payee_identifier" => config('telebirr.merchant_code'),
            "payee_identifier_type" => "04",
            "payee_type" => "5000",
            "redirect_url" => config('telebirr.redirect_url'),
        ];

        $payload = [
            "timestamp" => $timestamp,
            "nonce_str" => $nonce,
            "method" => "payment.preorder",
            "version" => "1.0",
            "biz_content" => $biz,
        ];

        $payload['sign'] = SignatureService::sign($payload);
        $payload['sign_type'] = "SHA256WithRSA";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-APP-Key' => config('telebirr.fabric_app_id'),
            'Authorization' => $token,
        ])->withOptions(['verify' => false])
            ->post(config('telebirr.base_url') . '/payment/v1/merchant/preOrder', $payload);
        if ($response->failed()) {
            throw new \Exception('Failed to create Telebirr order: ' . $response->body());
        }
        return $response;
    }

    public static function buildCheckoutUrl($prepayId)
    {
        $map = [
            "appid" => config('telebirr.merchant_app_id'),
            "merch_code" => config('telebirr.merchant_code'),
            "nonce_str" => Str::random(32),
            "prepay_id" => $prepayId,
            "timestamp" => time(),
        ];

        $sign = SignatureService::sign($map);
        $query = http_build_query(array_merge($map, [
            "sign" => $sign,
            "sign_type" => "SHA256WithRSA"
        ]));

        return config('telebirr.web_base_url') . $query . '&version=1.0&trade_type=WebCheckout&use_notice_key=false&language=en';
    }
}
