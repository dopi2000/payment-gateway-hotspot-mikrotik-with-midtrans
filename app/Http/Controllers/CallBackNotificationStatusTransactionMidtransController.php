<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class CallBackNotificationStatusTransactionMidtransController extends Controller
{
    public function callback(Request $request) {

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {

            $notif = new Notification();
            $transaction_status = $notif->transaction_status;
            $order_id = $notif->order_id;

            $item = Payment::where('order_id', $order_id)->first();

            if(!$item) {
                return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
            }

            switch ($transaction_status) {
                case 'settlement':
                    $this->updatedPaymentStatus($item, 'sukses', $notif);
                    redirect()->route('payment.success', ['order_id' => $item->order_id]);
                    break;
                case 'cancel':
                    $this->updatedPaymentStatus($item, 'gagal', $notif);
                    break;
                case 'expire':
                    $this->updatedPaymentStatus($item, 'gagal', $notif);
                    break;
                default:
                $this->updatedPaymentStatus($item, 'pending', $notif);
                    break;
            }

        } catch ( Exception $e) { 

            return response()->json(['error', $e->getMessage()], 500);

        }
    }

    protected function updatedPaymentStatus(Payment $payment, string $status, $notif) {

        $payment->update([
            'status' => $status,
            'price' => $notif->gross_amount
        ]);

    }
}
