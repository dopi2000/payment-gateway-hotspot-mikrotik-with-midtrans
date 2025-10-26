@push('head')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" 
    data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush
<x-layout-master :title="$title">
    <section class="bg-white py-8 antialiased  md:py-16">
        <div class="mx-auto max-w-2xl px-4 2xl:px-0">
            @if (session('status'))
            <div class="flex items-center p-4 mb-4 text-sm text-red-600 rounded-lg bg-red-50" role="alert">
              <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
              </svg>
              <span class="sr-only">Info</span>
              <div>
                <span class="font-medium">{{ session('status') }}</span>
              </div>
            </div>
            @endif
            <h2 class="text-xl font-semibold text-blue-600  sm:text-2xl mb-2">Detail Paket Internet Hotspot WiFi</h2>
            <p class="text-gray-500 mb-6 md:mb-8">Order ID : <span  class="font-medium text-gray-900  hover:underline">{{ $order_item->order_id }}</span>.<br> <span class="text-red-500">Perhatian: 
            Jika sudah lakukan pembayaran namun halaman tidak secara otomatis diredirect ke halaman sukses, tekan tombol cek transaksi yang ada pada halaman pilihan paket atau tombol cek transaksi dihalaman ini. sebelum diklik, salin terlebih dahulu order ID transaksi Anda. Harga Paket belum termasuk biaya admin. harga akhir yang dibayarkan setelah memilih metode pembayaran</span>
            </p>
            <div class="space-y-4 sm:space-y-2 rounded-lg border border-gray-100 bg-gray-50 p-6   mb-6 md:mb-8">
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Nama Paket</dt>
                    <dd class="font-medium text-gray-900 sm:text-end">{{ $order_item->package_name }}</dd>
                </dl>
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Tipe Paket</dt>
                    <dd class="font-medium text-gray-900  sm:text-end">{{ ucwords($order_item->package_key) }}</dd>
                </dl>
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Harga</dt>
                    <dd class="font-medium text-gray-900  sm:text-end">{{ Number::currency($order_item->price, locale: 'id', precision: 0) }}</dd>
                </dl>
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Kecepatan Internet</dt>
                    <dd class="font-medium text-gray-900  sm:text-end">{{ $order_item->bandwidth }}</dd>
                </dl>
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Batas Device Terhubung</dt>
                    <dd class="font-medium text-gray-900  sm:text-end">{{ $order_item->devices }} Perangkat</dd>
                </dl>
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Masa Penggunaan</dt>
                    <dd class="font-medium text-gray-900  sm:text-end">{{ $order_item->duration }} Hari</dd>
                </dl>
                <dl class="sm:flex items-center justify-between gap-4">
                    <dt class="font-normal mb-1 sm:mb-0 text-gray-500">Batas Kuota</dt>
                    <dd class="font-medium text-gray-900  sm:text-end">{{ $order_item->kuota }}</dd>
                </dl>
            </div>
            <div class="flex items-center space-x-4">
                <button onclick="payNow()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">Bayar</button>
                <a href="{{ route('check') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cek Transaksi</a>
            </div>
        </div>
        </section>
@push('foot')
<script>
    function payNow() {
      snap.pay("{{ $order_item->snap_token }}", {
        onSuccess: function(result) {
          window.location.href = "{{ route('payment.success', ['order_id' => $order_item->order_id ]) }}";
        },
        onPending: function(result) {
          window.location.href = "{{ route('payment.process', ['order_id' => $order_item->order_id ]) }}";
        },
        onError: function(result) {
          // window.location.href = "{{ route('index') }}";
        },
        onClose: function() {
          
        }
      });
    }
</script>
@endpush
</x-layout-master>
