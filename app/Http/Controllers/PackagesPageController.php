<?php

namespace App\Http\Controllers;

class PackagesPageController extends Controller
{
    public function packages() {

        $title = "Paket Hotspot WiFi - Adeeva Grosir Hotspot";
        $packages = [
                'daily' => [
                    'name' => 'Paket Harian',
                    'price' => 5000,
                    'devices' => 1,
                    'bandwidth' => '5 Mbps',
                    'duration' => 1,
                    'description' => 'Unlimited'
                ],
                'weekly' => [
                    'name' => 'Paket Mingguan', 
                    'price' => 20000,
                    'devices' => 2,
                    'bandwidth' => '7 Mbps',
                    'duration' => 7,
                    'description' => 'Unlimited'
                ],
                'monthly' => [
                    'name' => 'Paket Bulanan',
                    'price' => 60000,
                    'devices' => 3,
                    'bandwidth' => '10 Mbps', 
                    'duration' => 30,
                    'description' => 'Unlimited'
                ]
            ];

        return view('frontend.packages', compact('title', 'packages'));
    }
}
