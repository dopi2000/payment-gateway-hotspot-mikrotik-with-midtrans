<x-layout-master :title="$title"> 
 <section class="py-24 relative">
    <div class="w-full max-w-7xl px-4 md:px-5 lg-6 mx-auto">
        <h2 class="font-manrope font-bold text-4xl leading-10 text-black text-center">
            History Transaksi Anda
        </h2>
        <p class="mt-4 font-normal text-lg leading-8 text-gray-500 mb-11 text-center">Detail item dari transaksi anda</p>
        <div class="main-box border border-gray-200 rounded-xl pt-6 max-w-xl max-lg:mx-auto lg:max-w-full">
            <div
                class="flex flex-col lg:flex-row lg:items-center justify-between px-6 pb-6 border-b border-gray-200">
                <div class="data">
                    <p class="font-semibold text-base leading-7 text-black">Order ID: <span class="text-blue-600 font-medium">{{ $item->order_id }}</span></p>
                    <p class="font-semibold text-base leading-7 text-black mt-4">Tanggal Transaksi : <span class="text-gray-400 font-medium">{{ $item->created_at }}</span></p>
                    @if ($item->status === "sukses")
                    <p class="font-semibold text-base leading-7 text-black mt-4">User/Pass : <span class="text-gray-400 font-medium">{{ $item->username }}/{{ $item->password }}</span></p>
                    @endif
                </div>
                @if ($item->status === "pending")
                <button onclick="window.location.href = '{{ route('payment.process', ['order_id' => $item->order_id]) }}'"
                    class="rounded-full py-3 px-7 font-semibold text-sm leading-7 text-white bg-blue-600 max-lg:mt-5 shadow-sm shadow-transparent transition-all duration-500 hover:bg-blue-700 hover:shadow-blue-400">Bayar</button>
                @endif
                @if ($item->status === "sukses")
                    @if (!$check_user)
                    <button onclick="window.location.href = '{{ route('payment.success', ['order_id' => $item->order_id]) }}'"
                        class="rounded-full py-3 px-7 font-semibold text-sm leading-7 text-white bg-blue-600 max-lg:mt-5 shadow-sm shadow-transparent transition-all duration-500 hover:bg-blue-700 hover:shadow-blue-400">Aktifkan paket</button>
                    @endif
                @endif
            </div>
            <div class="w-full px-3 min-[400px]:px-6">
                <div class="flex flex-col lg:flex-row items-center py-6 border-b border-gray-200 gap-6 w-full">
                    <div class="flex flex-row items-center w-full ">
                        <div class="grid grid-cols-1 lg:grid-cols-2 w-full">
                            <div class="flex items-center">
                                <div class="">
                                    <h2 class="font-semibold text-xl leading-8 text-black mb-3">{{ $item->package_name }}</h2>
                                    <p class="font-normal text-lg leading-8 text-gray-500 mb-3 ">
                                        Kecepatan Internet: {{ ucwords($item->bandwidth) }}</p>
                                    <div class="flex items-center ">
                                        <p
                                            class="font-medium text-base leading-7 text-black pr-4 mr-4 border-r border-gray-200">
                                            Limit Kuota: <span class="text-gray-500">{{ $item->kuota }}</span></p>
                                        <p class="font-medium text-base leading-7 text-black ">Batas perangkat: <span class="text-gray-500">{{ $item->devices }}</span></p>
                                    </div>
                                </div>

                            </div>
                            <div class="grid grid-cols-5">
                                <div class="col-span-5 lg:col-span-1 flex items-center max-lg:mt-3">
                                    <div class="flex gap-3 lg:block">
                                        <p class="font-medium text-sm leading-7 text-black">Harga</p>
                                        <p class="lg:mt-4 font-medium text-sm leading-7 text-blue-600">{{ Number::currency($item->price, locale: 'id', precision: 0) }}</p>
                                    </div>
                                </div>
                                <div class="col-span-5 lg:col-span-2 flex items-center max-lg:mt-3 ">
                                    <div class="flex gap-3 lg:block">
                                        <p class="font-medium text-sm leading-7 text-black">Status
                                        </p>
                                        @if($item->status === "sukses") 
                                        <p class="font-medium text-sm leading-6 whitespace-nowrap py-0.5 px-3 rounded-full lg:mt-3 bg-emerald-50 text-emerald-600">{{ ucwords($item->status) }}</p>
                                        @elseif($item->status === "pending")
                                        <p class="font-medium text-sm leading-6 whitespace-nowrap py-0.5 px-3 rounded-full lg:mt-3 bg-blue-50 text-blue-600">{{ ucwords($item->status) }}</p>
                                        @else
                                        <p class="font-medium text-sm leading-6 whitespace-nowrap py-0.5 px-3 rounded-full lg:mt-3 bg-red-50 text-red-600">{{ ucwords($item->status) }}</p>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-span-5 lg:col-span-2 flex items-center max-lg:mt-3">
                                    <div class="flex gap-3 lg:block">
                                        <p class="font-medium text-sm whitespace-nowrap leading-6 text-black">
                                            Masa Berlaku</p>
                                        <p class="font-medium text-base whitespace-nowrap leading-7 lg:mt-3 text-blue-500">
                                            {{ $item->duration }} Hari</p>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>
            <div class="w-full border-t border-gray-200 px-6 flex flex-col lg:flex-row items-center justify-between ">
                <button onclick="window.location.href = '{{ route('index') }}'" class="flex outline-0 py-6 sm:pr-6  sm:border-r border-gray-200 whitespace-nowrap gap-2 items-center justify-center font-semibold group text-lg text-black bg-white transition-all duration-500 hover:text-blue-600">
                    <svg class="stroke-black transition-all duration-500 group-hover:stroke-blue-600" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22"
                        fill="none">
                        <path d="M5.5 5.5L16.5 16.5M16.5 5.5L5.5 16.5" stroke="" stroke-width="1.6"
                            stroke-linecap="round" />
                    </svg>
                    Kembali
                </button>
                <p class="font-semibold text-lg text-black py-6">Total Pembayaran: <span class="text-blue-600">{{ Number::currency($item->price, locale: 'id') }}</span></p>
            </div>

        </div>
    </div>
</section>
                                            
</x-layout-master>
