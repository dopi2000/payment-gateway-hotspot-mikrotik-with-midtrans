<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ValidatedFormController extends Controller
{
    public function ValidatedPackage(Request $request) {
        $validated = $request->validate([
            'package' => ['required', 'in:daily,weekly,monthly', 'string'],
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $packages = [
                    'daily' => [
                        'name' => 'Paket Harian',
                        'price' => 5000,
                        'devices' => 1,
                        'bandwidth' => '5 Mbps',
                        'duration' => 1,
                        'kuota' => 'Unlimited'
                    ],
                    'weekly' => [
                        'name' => 'Paket Mingguan', 
                        'price' => 20000,
                        'devices' => 2,
                        'bandwidth' => '7 Mbps',
                        'duration' => 7,
                        'kuota' => 'Unlimited'
                    ],
                    'monthly' => [
                        'name' => 'Paket Bulanan',
                        'price' => 60000,
                        'devices' => 3,
                        'bandwidth' => '10 Mbps', 
                        'duration' => 30,
                        'kuota' => 'Unlimited'
                    ]
                ];

        

        $package = $packages[$validated['package']];
        $username = Str::random(6);
        $order_id = 'trx-id_' . $username . bin2hex($username);

        $potongan_admin = 0.04;
        $biaya_transaksi = $package['price'] * $potongan_admin;
        $gross_amount = $package['price'] + $biaya_transaksi;
        $gross_amount_final = round($gross_amount, 0);



        $transaction_details = [
            'order_id' => $order_id,
            'gross_amount' => $gross_amount_final
        ];

        $item_details = [
            [
                'id' => $validated['package'],
                'price' => $package['price'],
                'quantity' => 1,
                'name' => $package['name']
            ],
            [
                'id' => 'Admin-Midtrans',
                'price' => $biaya_transaksi,  
                'quantity' => 1,
                'name' => 'Biaya Layanan/Transaksi (4%)',
            ]
            
        ];

        $customer_details = [
            'first_name' => $username,
            'last_name' => $username,
            'email' => $username . "@hotspot.net",
            'phone' => '',
            'billing_address'  => '',
            'shipping_address' => ''
        ];

        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details
        ];
        
        try {
            
            $snap_token = Snap::getSnapToken($transaction);

            Payment::create([
                'order_id' => $order_id,
                'username' => $username,
                'password' => $username,
                'package_key' => $validated['package'],
                'package_name' => $package['name'],
                'price' => $package['price'],
                'devices' => $package['devices'],
                'bandwidth' => $package['bandwidth'],
                'duration' => $package['duration'],
                'kuota' => $package['kuota'],
                'snap_token' => $snap_token
            ]);

            
        return  redirect()->route('payment.process', [ 'order_id' => $order_id ]);

        } catch( Exception $e) {

           $title = 'Sistem Pembayaran Gangguan - Adeeva Grosir Hotspot';
           return response()->view('frontend.error-page', ['title' => $title], 500);

        }
  
    }
}
