<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Telebirr\OrderService;
use App\Services\Telebirr\CallbackService;

class TelebirrController extends Controller
{
    public function showPayForm()
    {
        return view('telebirr.form');
    }

    public function submitPayment(Request $request)
    {
        $title = $request->input('title');
        $amount = $request->input('amount');

        $result = OrderService::createOrder($title, $amount);

        if (isset($result['biz_content']['prepay_id'])) {
            $prepayId = $result['biz_content']['prepay_id'];
            $checkoutUrl = OrderService::buildCheckoutUrl($prepayId);
            return redirect()->away($checkoutUrl);
        }

        return back()->with('error', 'Failed to create Telebirr order.');
    }

    public function handleCallback(Request $request)
    {
        return CallbackService::handle($request); // You can add logic here
    }

    public function handleRedirect(Request $request)
    {
        return view('telebirr.success');
    }
}
