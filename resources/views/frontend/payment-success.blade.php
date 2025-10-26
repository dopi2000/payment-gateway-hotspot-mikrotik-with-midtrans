<x-layout-master :title="$title">
 <div class="w-full min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gray-100 p-6 text-center">
            <div class="w-16 h-16 bg-white rounded-full border-2 border-green-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
            </div>
            <h1 class="text-2xl font-bold text-green-600">Pembayaran Berhasil</h1>
            <p class="text-gray-700 mt-2">{{ $message }}
            </p>
            <p class="text-red-600 mt-2">Peringatan: Halaman ini hanya tampil sekali. jika akun hotspot anda lupa, simpan order ID anda, silahkan ke halaman pilih paket lalu klik cek transaksi, kemudian inputkan order id Anda untuk lihat kembali akun hotspot anda. 
            </p>
        </div>
        
        <!-- Detail pesanan -->
        <div class="p-6">
          @if($createdNewUserHotspot)
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Order ID</span>
                    <span class="font-semibold">{{ $order_item->order_id }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Username</span>
                    <span class="font-semibold">{{ $order_item->username  }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Password</span>
                    <span class="font-semibold text-lg">{{ $order_item->password }}</span>
                </div>
                <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                    <span class="text-gray-600 font-medium">Masa Aktif</span>
                    <span class="font-semibold text-lg">{{ date('d/m/Y H:i', strtotime("+{$order_item->duration} days")) }}</span>
                </div>
            </div>
            @endif
            
            <!-- Tombol View Account -->
            @if ($createdNewUserHotspot)
            <div class="mt-8">
                <button onclick="window.location.href='{{ session('link-hotspot-login') }}?username={{ $order_item->username }}&password={{ $order_item->password }}'" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    Sambungkan ke Jaringan
                </button>
            </div>
             @endif
            
            <!-- Informasi tambahan -->
            <div class="mt-6 text-center text-sm text-gray-500">
                <a href="phone:082142531838" class="text-blue-600 hover:underline">Kontak Admin</a>
            </div>
        </div>
    </div>
</div>
</x-layout-master>
