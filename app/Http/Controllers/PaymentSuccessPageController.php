<?php

namespace App\Http\Controllers;

use Exception;
use RouterOS\Query;
use Midtrans\Config;
use RouterOS\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use RouterOS\Config as RouterOSConfig;

class PaymentSuccessPageController extends Controller
{
    public function paymentSuccess(Request $request) {
        $title = "Pembayaran Sukses - Adeeva Grosir Hotspot";
        $order_id = $request->query('order_id');
        $order_item = Payment::where('order_id', $order_id)->first();

        if($order_id === null) {
           return  redirect()->route('index')->with('status', 'Akses Halaman ditolak, silahkan pilih paket terlebih dahulu');
        }
        if($order_item === null ) {
            return  redirect()->route('index')->with('status', "Transaksi {$order_id}, tidak ditemukan. silahkan lakukan transaksi terlebih dahulu.");
        }

        if($order_item->status === "pending") {
            return redirect()->route('payment.process', ['order_id' => $order_item->order_id])->with('status', "Transaksi dengan {$order_item->order_id}, status transaksinya masih pending, silahkan selesaikan transaksi anda terlebih dahulu.");
        }
        
        if($order_item->status === "gagal") {
            return redirect()->route('index')->with('status', "Transaksi dengan order ID {$order_item->order_id}, status transaksi telah dibatalkan atau expired.");
        }
        
        $check_user_mikrotik = $this->checkUserHotspotInMikrotik($order_item->username);

        if(!$check_user_mikrotik) {
            $createdNewUserHotspot = $this->createNewUserHotspot(
                $order_item->username,
                $order_item->password,
                $order_item->package_key,
                $order_item->duration,
            );
            
            if($createdNewUserHotspot) {
                $message = "Paket internet hotspot anda berhasil diaktifkan. simpan username dan password atau screenshot halaman ini.";
            } else {
                $message = "Pembayaran berhasil tetapi paket internet hotspot WiFi gagal diaktifkan. Hubungi Admin : 082142531838";
            }
        } else {

            return redirect()->route('index')->with('status', "Transaksi dengan order ID {$order_item->order_id} sudah berhasil dan paket sudah diaktifkan");
        }

        return view('frontend.payment-success', compact('message', 'createdNewUserHotspot', 'order_item', 'title'));

    }

    protected function createNewUserHotspot(
        string $username, 
        string $password,
        string $package_key,
        string $duration,
    ) : bool
    {

        try {

            $config = new RouterOSConfig([
                'host' => config('mikrotik.host'),
                'user' => config('mikrotik.username'),
                'pass' => config('mikrotik.password'),
                'port' => config('mikrotik.port')
            ]);

            $client = new Client($config);
            $profile = $this->getProfileName($package_key);
            $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name', $username)
            ->equal('password', $password)
            ->equal('profile', $profile)
            ->equal('limit-uptime', $this->getUptimeLimit($duration))
            ->equal('disabled', 'no');

            $response = $client->query($query)->read();
            return true;

        } catch(Exception $e) {
            response()->json(['error' => 'Gagal terkoneksi ke router mikrotik'], 500);
            return false;
        }
    }

    protected function getProfileName($package_key) {
        $profiles = [
            'daily' => 'paket-harian',
            'weekly' => 'paket-mingguan', 
            'monthly' => 'paket-bulanan'
        ];
        return $profiles[$package_key] ?? 'default';
    }

    protected function getUptimeLimit($duration) {
        return $duration * 24 . 'h';
    }

    public function checkUserHotspotInMikrotik($username): bool {
        try {
            $config = new RouterOSConfig([
                'host' => config('mikrotik.host'),
                'user' => config('mikrotik.username'),
                'pass' => config('mikrotik.password'),
                'port' => config('mikrotik.port')
            ]);

            $client = new Client($config);
            $query = (new Query('/ip/hotspot/user/print'))->where('name', $username);
            $response = $client->query($query)->read();
            if(!empty($response)) {
                return true; 
            } else {
                return false;
            }
        } catch(Exception $e) {
            response()->json(['error' => 'Gagal terkoneksi ke router mikrotik'], 500);
            return false;
        }
    }
}
