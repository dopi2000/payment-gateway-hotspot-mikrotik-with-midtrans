<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class CheckStatusPaymentController extends Controller
{
    public function check() {
        $title = 'Cek Transaksi - Adeeva Grosir Hotspot';
        return view('frontend.check-status-payment', compact('title'));
    }

    public function validatedOrderId(Request $request) {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:payments,order_id']
        ]);
         
        $title = "History Transaksi - Adeeva Grosir Hotspot";

        $item = Payment::where('order_id', $validated['order_id'])->first();
        if($item->status === "sukses") {
            $userUnregisteredHotspot = $this->checkUserRegisteredInMikrotik($item->username);
            return response()->view('frontend.transaction-detail', ['item' => $item, 'title' => $title, 'check_user' => $userUnregisteredHotspot], 200);
        }
        return response()->view('frontend.transaction-detail', ['item' => $item, 'title' => $title], 200);
    }

    public function checkUserRegisteredInMikrotik($username) : bool {

        $checkUserRegistered = new PaymentSuccessPageController();
        return $checkUserRegistered->checkUserHotspotInMikrotik($username);
    }
}
