<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;


class PaymentProcessPageController extends Controller
{
     public function paymentProcess(Request $request) {
        $title = 'Pembayaran - Adeeva Grosir Hotspot';
        $order_id = $request->query('order_id');
        
        if($order_id === null) {
          return  redirect()->route('index')->with('status', 'Akses Halaman ditolak, silahkan pilih paket terlebih dahulu');
        }

        $order_item = Payment::where('order_id', $order_id)->first();

        if($order_item === null) {
          return  redirect()->route('index')->with('status', "Transaksi dengan order ID {$order_id}, tidak ditemukan.");
        }
        switch ($order_item->status) {
          case 'sukses':
            return  redirect()->route('index')->with('status', "Transaksi dengan order ID {$order_id}, status transaksi sudah berhasil dan paket hotspotnya telah aktif");
            break;
          case 'gagal':
            return  redirect()->route('index')->with('status', "Transaksi dengan order ID {$order_id}, status transaksi telah dibatalkan atau telah expired");
            break;
        }
        return view('frontend.payment', compact('title', 'order_item'));
    }
}
